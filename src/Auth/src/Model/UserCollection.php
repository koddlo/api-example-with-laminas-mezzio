<?php

declare(strict_types=1);

namespace Auth\Model;

class UserCollection
{
    private array $users;

    public function __construct()
    {
        $this->users = [];
    }

    public function get(string $userId): ?User
    {
        return $this->users[$userId] ?? null;
    }

    public function add(UserInterface $user): void
    {
        $this->users[$user->getIdentity()] = $user;
    }
}
