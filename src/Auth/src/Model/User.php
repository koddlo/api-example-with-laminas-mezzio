<?php

declare(strict_types=1);

namespace Auth\Model;

class User implements UserInterface
{
    private string $identity;

    private string $hashedPassword;

    private array $ipAddresses;

    public function __construct(
        string $identity,
        string $hashedPassword,
        array $ipAddresses
    ) {
        $this->identity = $identity;
        $this->hashedPassword = $hashedPassword;
        $this->ipAddresses = $ipAddresses;
    }

    public function getIdentity(): string
    {
        return $this->identity;
    }

    public function isPasswordValid(string $password): bool
    {
        return password_verify($password, $this->hashedPassword);
    }

    public function getIpAddresses(): array
    {
        return $this->ipAddresses;
    }

    public function getRoles(): iterable
    {
        return [];
    }

    public function getDetail(string $name, $default = null): mixed
    {
        return $default;
    }

    public function getDetails(): array
    {
        return [];
    }
}
