<?php

namespace App\Domain\ValueObjects\User;

class Roles
{

    public function __construct(
        private array $roles
    )
    {
    }

    public static function fromString(string $roles): Roles
    {
        return new Roles(explode(',', $roles));
    }

    public function toString(): string
    {
        return implode(',', $this->roles);
    }

    public function toArray(): array
    {
        return $this->roles;
    }

    public function hasRole(array $role): bool
    {
        return !empty(array_intersect($role, $this->roles));
    }


}