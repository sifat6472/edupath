<?php
namespace App\Http\Middleware;

class CsrfMiddleware
{
    public function handle(): bool
    {
        if (in_array($_SERVER['REQUEST_METHOD'] ?? '', ['POST', 'PUT', 'DELETE'])) {
            $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
            if (!hash_equals($_SESSION['_csrf_token'] ?? '', $token)) {
                http_response_code(419);
                die('CSRF token mismatch.');
            }
        }
        return true;
    }
}
