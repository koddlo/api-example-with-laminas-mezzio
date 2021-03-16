<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Query\QueryMarkerInterface;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Store\Service\StoreInterface;

class QueryAbstractFactory implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        return str_contains($requestedName, 'Customer\\Query')
            && (new \ReflectionClass($requestedName))->implementsInterface(QueryMarkerInterface::class);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): QueryMarkerInterface
    {
        return new $requestedName(
            $container->get(StoreInterface::class)
        );
    }
}
