<?php
namespace App\Services;

use App\Repositories\UserRepository;

/**
 * Authentication Service
 * Implements Singleton Pattern
 */
class AuthService
{
    private static ?AuthService $instance = null;
    private UserRepository $userRepository;
    private ?array $currentUser = null;

    private function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->loadUserFromSession();
    }

    public static function getInstance(): AuthService
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function loadUserFromSession(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->currentUser = $this->userRepository->find((int) $_SESSION['user_id']);
        }
    }

    public function attempt(string $email, string $password): bool
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) return false;
        if (!password_verify($password, $user['password'])) return false;

        $this->loginUser($user);
        return true;
    }

    public function loginUser(array $user): void
    {
        // Regenerate session ID for security
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $this->currentUser = $user;
    }

    public function register(string $name, string $email, string $password, string $role = 'student'): int
    {
        if ($this->userRepository->findByEmail($email)) {
            throw new \Exception('Email already registered');
        }
        $id = $this->userRepository->createUser($name, $email, $password, $role);
        return $id;
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
        }
        session_destroy();
        $this->currentUser = null;
    }

    public function check(): bool
    {
        return $this->currentUser !== null;
    }

    public function user(): ?array
    {
        return $this->currentUser;
    }

    public function id(): ?int
    {
        return $this->currentUser['id'] ?? null;
    }

    public function role(): ?string
    {
        return $this->currentUser['role'] ?? null;
    }

    public function hasRole(string $role): bool
    {
        return $this->role() === $role;
    }
}
