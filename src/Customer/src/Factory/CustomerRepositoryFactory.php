<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Repository\CustomerRepository;
use Customer\Repository\CustomerRepositoryInterface;
use Customer\Service\CustomerNormalizer;
use Psr\Container\ContainerInterface;
use Store\Service\StoreInterface;

class CustomerRepositoryFactory
{
    public function __invoke(ContainerInterface $container): CustomerRepositoryInterface
    {
        return new CustomerRepository(
            $container->get(StoreInterface::class),
            new CustomerNormalizer()
        );
    }
}
