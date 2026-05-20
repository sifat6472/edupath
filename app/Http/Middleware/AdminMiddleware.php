<?php
namespace App\Http\Middleware;

use App\Services\AuthService;
use App\Core\Response;

class AdminMiddleware
{
    public function handle(): bool
    {
        $auth = AuthService::getInstance();
        if (!$auth->check() || !$auth->hasRole('admin')) {
            http_response_code(403);
            echo "Forbidden — Admin access required.";
            return false;
        }
        return true;
    }
}
