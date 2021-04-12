<?php

declare(strict_types=1);

namespace Error\Factory;

use Error\Service\JsonErrorResponseGenerator;
use Psr\Container\ContainerInterface;

class JsonErrorResponseGeneratorFactory
{
    public function __invoke(ContainerInterface $container): JsonErrorResponseGenerator
    {
        return new JsonErrorResponseGenerator($container->get('config')['debug'] ?? false);
    }
}
