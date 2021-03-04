<?php

declare(strict_types=1);

namespace Store\Factory;

use Interop\Container\ContainerInterface;
use MongoDB\Client;
use Store\Service\DatabaseAdapter;
use Webmozart\Assert\Assert;

class DatabaseAdapterFactory
{
    private const MONGO_DEFAULT_HOST = '127.0.0.1';
    private const MONGO_DEFAULT_PORT = '27017';

    public function __invoke(ContainerInterface $container): DatabaseAdapter
    {
        $mongoConfig = $container->get('config')['mongo'] ?? [];
        Assert::notEmpty($mongoConfig, 'MongoDB config not found.');

        $mongoClient = new Client(sprintf(
            'mongodb://%s:%s',
            $mongoConfig['server'] ?? self::MONGO_DEFAULT_HOST,
            $mongoConfig['port'] ?? self::MONGO_DEFAULT_PORT
        ));

        return new DatabaseAdapter(
            $mongoClient->selectDatabase($mongoConfig['dbname'])
        );
    }
}
