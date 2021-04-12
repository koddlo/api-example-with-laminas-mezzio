<?php

declare(strict_types=1);

namespace Error\Factory;

use Error\Listener\ErrorLogListener;
use Error\Service\LoggerInterface;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Container\ContainerInterface;

class ErrorHandlerDelegatorFactory
{
    public function __invoke(ContainerInterface $container, string $name, callable $callback): ErrorHandler
    {
        $listener = new ErrorLogListener($container->get(LoggerInterface::class));
        $errorHandler = $callback();
        $errorHandler->attachListener($listener);

        return $errorHandler;
    }
}
