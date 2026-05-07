<?php

declare(strict_types=1);

/**
 * Lightweight migration runner for cPanel Git deploy.
 *
 * Usage:
 *   php scripts/db_migrate.php --path=/absolute/app/path
 */

$appPath = null;
foreach ($argv as $arg) {
    if (str_starts_with($arg, '--path=')) {
        $appPath = substr($arg, 7);
    }
}

if (!$appPath) {
    $appPath = dirname(__DIR__);
}

$envFile = rtrim($appPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '.env';
if (!file_exists($envFile)) {
    fwrite(STDOUT, "[db_migrate] .env no encontrado, se omiten migraciones.\n");
    exit(0);
}

require_once $appPath . '/src/Core/Env.php';

\App\Core\Env::load($envFile);

$host = \App\Core\Env::get('DB_HOST', 'localhost');
$port = \App\Core\Env::get('DB_PORT', '3306');
$name = \App\Core\Env::get('DB_NAME', 'havre_estates');
$user = \App\Core\Env::get('DB_USER', 'root');
$pass = \App\Core\Env::get('DB_PASS', '');

$dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $name);

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Throwable $e) {
    fwrite(STDERR, "[db_migrate] No se pudo conectar a DB: " . $e->getMessage() . "\n");
    exit(1);
}

$pdo->exec(
    "CREATE TABLE IF NOT EXISTS schema_migrations (\n"
    . "  id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,\n"
    . "  migration VARCHAR(255) NOT NULL UNIQUE,\n"
    . "  applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP\n"
    . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
);

$migrationsDir = $appPath . '/database/migrations';
if (!is_dir($migrationsDir)) {
    fwrite(STDOUT, "[db_migrate] Directorio de migraciones no encontrado, se omite.\n");
    exit(0);
}

$files = glob($migrationsDir . '/*.sql');
sort($files);

if (!$files) {
    fwrite(STDOUT, "[db_migrate] No hay migraciones pendientes.\n");
    exit(0);
}

$selectStmt = $pdo->prepare('SELECT 1 FROM schema_migrations WHERE migration = :migration LIMIT 1');
$insertStmt = $pdo->prepare('INSERT INTO schema_migrations (migration) VALUES (:migration)');

foreach ($files as $file) {
    $migration = basename($file);

    $selectStmt->execute(['migration' => $migration]);
    if ($selectStmt->fetchColumn()) {
        fwrite(STDOUT, "[db_migrate] Ya aplicada: {$migration}\n");
        continue;
    }

    $sql = file_get_contents($file);
    if ($sql === false || trim($sql) === '') {
        fwrite(STDOUT, "[db_migrate] Vacia/ilegible, se omite: {$migration}\n");
        continue;
    }

    try {
        $pdo->beginTransaction();
        $pdo->exec($sql);
        $insertStmt->execute(['migration' => $migration]);
        $pdo->commit();
        fwrite(STDOUT, "[db_migrate] OK: {$migration}\n");
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        fwrite(STDERR, "[db_migrate] ERROR en {$migration}: " . $e->getMessage() . "\n");
        exit(1);
    }
}

fwrite(STDOUT, "[db_migrate] Migraciones finalizadas.\n");