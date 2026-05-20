<?php
namespace App\Http\Controllers;

use App\Core\Controller;
use App\Core\Response;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function showLogin(): string
    {
        return $this->view('auth.login', ['title' => 'Login - EduPath']);
    }

    public function login(): string
    {
        $this->validateCsrf();
        $data = $this->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $auth = AuthService::getInstance();
        if ($auth->attempt($data['email'], $data['password'])) {
            return $this->redirect('/dashboard');
        }

        Response::flash('error', 'Invalid email or password.');
        Response::flash('old', ['email' => $data['email']]);
        return $this->back();
    }

    public function showRegister(): string
    {
        return $this->view('auth.register', ['title' => 'Sign Up - EduPath']);
    }

    public function register(): string
    {
        $this->validateCsrf();
        $data = $this->validate([
            'name' => 'required|min:2|max:100',
            'email' => 'required|email|max:150',
            'password' => 'required|min:6|max:100',
        ]);

        $auth = AuthService::getInstance();
        try {
            $userId = $auth->register($data['name'], $data['email'], $data['password'], 'student');
            $user = (new \App\Repositories\UserRepository())->find($userId);
            $auth->loginUser($user);

            // Welcome notification
            (new \App\Services\NotificationService())->send(
                $userId,
                'Welcome to EduPath!',
                'Complete your profile to get personalized program recommendations.',
                'success',
                '/profile'
            );

            return $this->redirect('/preferences');
        } catch (\Exception $e) {
            Response::flash('error', $e->getMessage());
            Response::flash('old', $data);
            return $this->back();
        }
    }

    public function logout(): string
    {
        AuthService::getInstance()->logout();
        return $this->redirect('/');
    }

    public function showPreferences(): string
    {
        return $this->view('auth.preferences', ['title' => 'Set Your Preferences']);
    }

    public function savePreferences(): string
    {
        $this->validateCsrf();
        $auth = AuthService::getInstance();
        if (!$auth->check()) return $this->redirect('/login');

        $db = \App\Core\Database::getInstance();
        $userId = $auth->id();

        $data = [
            'user_id' => $userId,
            'preferred_country' => trim($_POST['preferred_country'] ?? ''),
            'preferred_field' => trim($_POST['preferred_field'] ?? ''),
            'preferred_degree' => trim($_POST['preferred_degree'] ?? ''),
            'budget_range' => trim($_POST['budget_range'] ?? ''),
            'interests' => trim($_POST['interests'] ?? ''),
        ];

        // Upsert
        $existing = $db->fetchOne("SELECT id FROM user_preferences WHERE user_id = ?", [$userId]);
        if ($existing) {
            $db->update('user_preferences', $data, 'user_id = :user_id', ['user_id' => $userId]);
        } else {
            $db->insert('user_preferences', $data);
        }

        return $this->redirect('/dashboard');
    }
}
