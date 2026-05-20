<?php
namespace App\Repositories;

class UserRepository extends BaseRepository
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        return $this->findBy('email', $email);
    }

    public function createUser(string $name, string $email, string $password, string $role = 'student'): int
    {
        return $this->create([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
        ]);
    }
}
