<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Middleware\CustomerExistenceMiddleware;
use Customer\Query\GetOneCustomerById;
use Psr\Container\ContainerInterface;

class CustomerExistenceMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): CustomerExistenceMiddleware
    {
        return new CustomerExistenceMiddleware(
            $container->get(GetOneCustomerById::class)
        );
    }
}
