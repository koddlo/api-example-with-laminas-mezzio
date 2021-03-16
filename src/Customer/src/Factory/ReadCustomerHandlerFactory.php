<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Handler\ReadCustomerHandler;
use Customer\Query\GetOneCustomerById;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReadCustomerHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        return new ReadCustomerHandler(
            $container->get(GetOneCustomerById::class)
        );
    }
}
