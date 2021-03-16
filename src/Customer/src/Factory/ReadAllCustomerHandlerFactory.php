<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Handler\ReadAllCustomerHandler;
use Customer\Query\CountCustomerQuery;
use Customer\Query\GetAllCustomer;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReadAllCustomerHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new ReadAllCustomerHandler(
            $container->get(CountCustomerQuery::class),
            $container->get(GetAllCustomer::class)
        );
    }
}
