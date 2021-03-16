<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Handler\DeleteCustomerHandler;
use Customer\Repository\CustomerRepositoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteCustomerHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new DeleteCustomerHandler(
            $container->get(CustomerRepositoryInterface::class)
        );
    }
}
