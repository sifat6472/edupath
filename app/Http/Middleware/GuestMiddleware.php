<?php
namespace App\Http\Middleware;

use App\Services\AuthService;
use App\Core\Response;

class GuestMiddleware
{
    public function handle(): bool
    {
        $auth = AuthService::getInstance();
        if ($auth->check()) {
            Response::redirect('/dashboard');
            return false;
        }
        return true;
    }
}
