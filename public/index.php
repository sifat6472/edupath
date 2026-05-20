<?php
/**
 * EduPath - Global Education Platform
 * Entry Point (Front Controller)
 * 
 * MVC + Repository + Service Layer + Middleware Architecture
 */

// Serve static assets through PHP built-in server
if (php_sapi_name() === 'cli-server') {
    $uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    if ($uri !== '/' && file_exists(__DIR__ . $uri) && !is_dir(__DIR__ . $uri)) {
        return false;
    }
}

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('RESOURCES_PATH', BASE_PATH . '/resources');
define('STORAGE_PATH', BASE_PATH . '/storage');

require_once BASE_PATH . '/bootstrap/app.php';

// Bootstrap the application (Singleton)
$app = \App\Core\Application::getInstance();
$app->run();
