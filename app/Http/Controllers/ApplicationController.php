<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Services\AuthService;
use App\Repositories\ApplicationRepository;

class ApplicationController extends Controller
{
    public function index(): string
    {
        $auth = AuthService::getInstance();
        $repo = new ApplicationRepository();
        $applications = $repo->getUserApplications($auth->id());

        $showSuccess = isset($_GET['submitted']);

        return $this->view('applications.index', [
            'title' => 'My Applications',
            'applications' => $applications,
            'showSuccess' => $showSuccess,
        ]);
    }
}
