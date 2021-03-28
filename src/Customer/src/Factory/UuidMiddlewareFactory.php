<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Middleware\UuidMiddleware;
use Interop\Container\ContainerInterface;

class UuidMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): UuidMiddleware
    {
        return new UuidMiddleware();
    }
}
