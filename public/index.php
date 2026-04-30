<?php

/**
 * HAVRE ESTATES - Entry Point
 * 
 * Punto de entrada único para todas las requests HTTP.
 * El router se encarga de despachar a los controladores correspondientes.
 */

// Define application paths
define('ROOT_PATH', dirname(__DIR__));
define('SRC_PATH', ROOT_PATH . '/src');
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('STORAGE_PATH', ROOT_PATH . '/storage');

// Load environment variables
require_once ROOT_PATH . '/src/Core/Env.php';
App\Core\Env::load(ROOT_PATH . '/.env');

// Load Composer autoloader
require_once ROOT_PATH . '/vendor/autoload.php';

// Start session
session_start();

// Initialize router
$router = new App\Core\Router();

// Load routes
require_once ROOT_PATH . '/routes/web.php';

// Dispatch request
$router->dispatch();

