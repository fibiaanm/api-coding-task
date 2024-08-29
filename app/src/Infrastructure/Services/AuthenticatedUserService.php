<?php

namespace App\Infrastructure\Services;

use App\Domain\Entities\User;

class AuthenticatedUserService
{

    private User $user;

    public function save(User $user): void
    {
        $this->user = $user;
    }

    public function get(): User
    {
        return $this->user;
    }

}