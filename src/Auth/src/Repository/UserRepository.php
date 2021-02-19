<?php

declare(strict_types=1);

namespace Auth\Repository;

use Auth\Model\UserCollection;
use Mezzio\Authentication\UserInterface;

class UserRepository implements UserRepositoryInterface
{
    private UserCollection $users;

    public function __construct(UserCollection $users)
    {
        $this->users = $users;
    }

    public function authenticate(string $credential, ?string $password = null): ?UserInterface
    {
        $user = $this->users->get($credential);

        return $user?->isPasswordValid($password) ? $user : null;
    }
}
