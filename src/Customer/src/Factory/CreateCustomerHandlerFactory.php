<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Handler\CreateCustomerHandler;
use Customer\Repository\CustomerRepositoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateCustomerHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new CreateCustomerHandler(
            $container->get(CustomerRepositoryInterface::class)
        );
    }
}
