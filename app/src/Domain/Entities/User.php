<?php

namespace App\Domain\Entities;

class User
{
    public int $id;
    public string $name;
    private string $password;
    public string $token = "";
    public array $roles = [];

    static function fromSqlResponse(array $data): User
    {
        $user = new User();
        $user->id = $data['id'];
        $user->name = $data['user_name'];
        $user->password = $data['user_password'];
        $user->roles = explode(',', $data['user_rol']);
        return $user;
    }

    public function validatePassword(string $password): bool
    {
        return $password === $this->password;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'token' => $this->token,
            'roles' => $this->roles
        ];
    }
}