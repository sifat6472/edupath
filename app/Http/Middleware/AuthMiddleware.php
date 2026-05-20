<?php
namespace App\Http\Middleware;

use App\Services\AuthService;
use App\Core\Response;

class AuthMiddleware
{
    public function handle(): bool
    {
        $auth = AuthService::getInstance();
        if (!$auth->check()) {
            $_SESSION['_flash']['error'] = 'Please log in to continue.';
            Response::redirect('/login');
            return false;
        }
        return true;
    }
}
