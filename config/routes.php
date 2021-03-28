<?php

declare(strict_types=1);

use Customer\Handler\CreateCustomerHandler;
use Customer\Handler\DeleteCustomerHandler;
use Customer\Handler\ReadAllCustomerHandler;
use Customer\Handler\ReadCustomerHandler;
use Customer\Handler\UpdateCustomerHandler;
use Customer\Middleware\CustomerExistenceMiddleware;
use Customer\Middleware\CustomerValidationMiddleware;
use Customer\Middleware\UuidMiddleware;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (
    Application $app,
    MiddlewareFactory $factory,
    ContainerInterface $container
): void {
    $app->post(
        '/api/v1/customer',
        [
            CustomerValidationMiddleware::class,
            CreateCustomerHandler::class
        ],
        'customer.create'
    );
    $app->get(
        '/api/v1/customer',
        ReadAllCustomerHandler::class,
        'customer.readAll'
    );
    $app->get(
        '/api/v1/customer/{customerId}',
        [
            UuidMiddleware::class,
            CustomerExistenceMiddleware::class,
            ReadCustomerHandler::class
        ],
        'customer.read'
    );
    $app->patch(
        '/api/v1/customer/{customerId}',
        [
            UuidMiddleware::class,
            CustomerExistenceMiddleware::class,
            CustomerValidationMiddleware::class,
            UpdateCustomerHandler::class
        ],
        'customer.update'
    );
    $app->delete(
        '/api/v1/customer/{customerId}',
        [
            UuidMiddleware::class,
            CustomerExistenceMiddleware::class,
            DeleteCustomerHandler::class
        ],
        'customer.delete'
    );
};
