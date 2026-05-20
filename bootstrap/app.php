<?php
/**
 * Application Bootstrap
 * Autoloads classes using PSR-4 like structure
 */

spl_autoload_register(function ($class) {
    // Convert namespace to file path
    $prefix = 'App\\';
    $base_dir = BASE_PATH . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

// Load configuration
$GLOBALS['config'] = require BASE_PATH . '/config/app.php';

// Start secure session
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

// CSRF Token generation
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}
