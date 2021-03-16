<?php

declare(strict_types=1);

use Customer\Handler\CreateCustomerHandler;
use Customer\Handler\DeleteCustomerHandler;
use Customer\Handler\ReadAllCustomerHandler;
use Customer\Handler\ReadCustomerHandler;
use Customer\Handler\UpdateCustomerHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (
    Application $app,
    MiddlewareFactory $factory,
    ContainerInterface $container
): void {
    $app->post('/api/v1/customer', CreateCustomerHandler::class, 'customer.create');
    $app->get('/api/v1/customer', ReadAllCustomerHandler::class, 'customer.readAll');
    $app->get('/api/v1/customer/{customerId}', ReadCustomerHandler::class, 'customer.read');
    $app->patch('/api/v1/customer/{customerId}', UpdateCustomerHandler::class, 'customer.update');
    $app->delete('/api/v1/customer/{customerId}', DeleteCustomerHandler::class, 'customer.delete');
};
