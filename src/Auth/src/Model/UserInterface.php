<?php

declare(strict_types=1);

namespace Auth\Model;

use Mezzio\Authentication\UserInterface as AuthUserInterface;

interface UserInterface extends AuthUserInterface
{
    public function isPasswordValid(string $password): bool;

    public function getIpAddresses(): array;
}
