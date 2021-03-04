<?php

declare(strict_types=1);

namespace Store;

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
                Service\StoreInterface::class => Service\DatabaseAdapter::class
            ],
            'factories' => [
                Service\DatabaseAdapter::class => Factory\DatabaseAdapterFactory::class
            ]
        ];
    }
}
