<?php

declare(strict_types=1);

namespace Auth;

use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\Basic\BasicAccess;
use Mezzio\Authentication\UserRepositoryInterface;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies()
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases' => [
                UserRepositoryInterface::class => Repository\UserRepository::class,
                AuthenticationInterface::class => BasicAccess::class
            ],
            'factories'  => [
                Repository\UserRepository::class => Factory\UserRepositoryFactory::class,
                Middleware\IpAccessControlMiddleware::class => Factory\IpAccessControlMiddlewareFactory::class
            ]
        ];
    }
}
