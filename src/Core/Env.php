<?php

namespace App\Core;

/**
 * Environment Configuration Loader
 */
class Env
{
    private static array $vars = [];

    /**
     * Load .env file and parse variables
     */
    public static function load(string $filePath): void
    {
        if (!file_exists($filePath)) {
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            // Skip comments
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            // Parse KEY=VALUE
            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value);

                // Remove quotes
                $value = trim($value, '"\'');

                self::$vars[$key] = $value;
                putenv("{$key}={$value}");
            }
        }
    }

    /**
     * Get environment variable
     */
    public static function get(string $key, string|null $default = null): string|null
    {
        return self::$vars[$key] ?? getenv($key) ?: $default;
    }

    /**
     * Check if variable exists
     */
    public static function has(string $key): bool
    {
        return isset(self::$vars[$key]) || getenv($key) !== false;
    }

    /**
     * Get all variables
     */
    public static function all(): array
    {
        return self::$vars;
    }
}
