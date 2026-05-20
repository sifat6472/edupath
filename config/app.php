<?php
/**
 * Application Configuration
 */

return [
    'name' => 'EduPath',
    'tagline' => 'Your Path to Global Education',
    'env' => 'local',
    'debug' => true,
    'url' => 'http://localhost:8000',
    
    'database' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'edupath',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],

    // Fallback to SQLite for instant run
    'use_sqlite_fallback' => true,
    'sqlite_path' => BASE_PATH . '/storage/edupath.sqlite',
    
    'session' => [
        'lifetime' => 120,
        'expire_on_close' => false,
    ],
    
    'roles' => [
        'student' => 'Student',
        'admin' => 'Admin',
        'professor' => 'Professor',
    ],
];
