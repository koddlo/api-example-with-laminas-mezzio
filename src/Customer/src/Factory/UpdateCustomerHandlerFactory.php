<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Handler\UpdateCustomerHandler;
use Customer\Repository\CustomerRepositoryInterface;
use Customer\Service\CustomerUpdater;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class UpdateCustomerHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new UpdateCustomerHandler(
            $container->get(CustomerRepositoryInterface::class),
            new CustomerUpdater()
        );
    }
}
