<?php
/**
 * Web Routes
 * RESTful routing structure with middleware-based protection
 */

/** @var \App\Core\Router $router */

// === Public Routes ===
$router->get('/', 'HomeController@index');

// Public — programs and scholarships browsable without login
$router->get('/programs', 'ProgramController@index');
$router->get('/programs/{id}', 'ProgramController@show');
$router->get('/scholarships', 'ScholarshipController@index');
$router->get('/scholarships/{id}', 'ScholarshipController@show');

// === Guest Routes (only for non-authenticated) ===
$router->group(['middleware' => ['GuestMiddleware']], function ($router) {
    $router->get('/login', 'AuthController@showLogin');
    $router->post('/login', 'AuthController@login');
    $router->get('/register', 'AuthController@showRegister');
    $router->post('/register', 'AuthController@register');
});

// === Authenticated Routes ===
$router->group(['middleware' => ['AuthMiddleware']], function ($router) {
    // Logout
    $router->post('/logout', 'AuthController@logout');

    // Preferences
    $router->get('/preferences', 'AuthController@showPreferences');
    $router->post('/preferences', 'AuthController@savePreferences');

    // Dashboard
    $router->get('/dashboard', 'DashboardController@index');
    $router->get('/notifications', 'DashboardController@notifications');
    $router->post('/notifications/{id}/read', 'DashboardController@markNotificationRead');
    $router->post('/notifications/mark-all-read', 'DashboardController@markAllNotificationsRead');

    // Profile
    $router->get('/profile', 'ProfileController@index');

    // Program applications
    $router->get('/programs/{id}/apply', 'ProgramController@apply');
    $router->post('/programs/{id}/apply', 'ProgramController@submitApplication');
    $router->post('/programs/{id}/save', 'ProgramController@toggleSave');

    // Scholarship applications
    $router->get('/scholarships/{id}/apply', 'ScholarshipController@apply');
    $router->post('/scholarships/{id}/apply', 'ScholarshipController@submitApplication');

    // Professors (auth-required)
    $router->get('/professors', 'ProfessorController@index');
    $router->get('/professors/{id}', 'ProfessorController@show');
    $router->get('/professors/{id}/contact', 'ProfessorController@contact');
    $router->post('/professors/{id}/contact', 'ProfessorController@sendContact');

    // Applications
    $router->get('/applications', 'ApplicationController@index');
});
