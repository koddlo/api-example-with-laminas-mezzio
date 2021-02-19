<?php

declare(strict_types=1);

namespace Auth\Factory;

use Auth\Middleware\IpAccessControlMiddleware;
use Interop\Container\ContainerInterface;
use Mezzio\Authentication\AuthenticationInterface;
use Webmozart\Assert\Assert;

class IpAccessControlMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): IpAccessControlMiddleware
    {
        $authentication = $container->has(AuthenticationInterface::class)
            ? $container->get(AuthenticationInterface::class)
            : null;
        Assert::notNull($authentication, 'AuthenticationInterface service is missing');
        Assert::isInstanceOf($authentication, AuthenticationInterface::class);

        return new IpAccessControlMiddleware($authentication);
    }
}
