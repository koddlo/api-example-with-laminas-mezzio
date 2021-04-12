<?php

declare(strict_types=1);

namespace Error\Factory;

use Laminas\Stratigility\Middleware\ErrorHandler;
use Error\Service\JsonErrorResponseGenerator;
use Mezzio\Middleware\ErrorResponseGenerator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;

class CustomErrorHandlerFactory
{
    public function __invoke(ContainerInterface $container): ErrorHandler
    {
        $generator = $container->has(JsonErrorResponseGenerator::class)
            ? $container->get(JsonErrorResponseGenerator::class)
            : $container->get(ErrorResponseGenerator::class);

        return new ErrorHandler($container->get(ResponseInterface::class), $generator);
    }
}
