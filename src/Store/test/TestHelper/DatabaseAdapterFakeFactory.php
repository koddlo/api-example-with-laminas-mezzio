<?php

declare(strict_types=1);

namespace StoreTest\TestHelper;

use MongoDB\Client;
use Store\Service\DatabaseAdapter;
use Webmozart\Assert\Assert;

class DatabaseAdapterFakeFactory
{
    private const MONGO_TEST_CONFIG_FILE_NAME = 'mongo.test.local.php';

    public function create(): DatabaseAdapter
    {
        $testMongoConfig = $this->getTestMongoConfig();
        $mongoClient = new Client(sprintf('mongodb://%s:%s', $testMongoConfig['server'], $testMongoConfig['port']));

        return new DatabaseAdapter(
            $mongoClient->selectDatabase($testMongoConfig['dbname'])
        );
    }

    private function getTestMongoConfig(): array
    {
        $testMongoConfig = require self::MONGO_TEST_CONFIG_FILE_NAME;
        Assert::notEmpty($testMongoConfig['testMongo'], 'Test MongoDB config not found.');

        return $testMongoConfig['testMongo'];
    }
}
