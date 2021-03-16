<?php

declare(strict_types=1);

namespace Customer;

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
                Repository\CustomerRepositoryInterface::class => Repository\CustomerRepository::class
            ],
            'factories'  => [
                Handler\CreateCustomerHandler::class => Factory\CreateCustomerHandlerFactory::class,
                Handler\ReadCustomerHandler::class => Factory\ReadCustomerHandlerFactory::class,
                Handler\ReadAllCustomerHandler::class => Factory\ReadAllCustomerHandlerFactory::class,
                Handler\UpdateCustomerHandler::class => Factory\UpdateCustomerHandlerFactory::class,
                Handler\DeleteCustomerHandler::class => Factory\DeleteCustomerHandlerFactory::class,
                Repository\CustomerRepository::class => Factory\CustomerRepositoryFactory::class
            ],
            'abstract_factories' => [
                Factory\QueryAbstractFactory::class
            ]
        ];
    }
}
