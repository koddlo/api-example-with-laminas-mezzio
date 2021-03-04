<?php

declare(strict_types=1);

namespace StoreTest\Service;

use PHPUnit\Framework\TestCase;
use Store\Service\DatabaseAdapter;
use StoreTest\TestHelper\DatabaseAdapterFakeFactory;

class DatabaseAdapterTest extends TestCase
{
    private const TEST_COLLECTION_NAME = 'test';

    private DatabaseAdapter $databaseAdapter;

    public function setUp(): void
    {
        $this->databaseAdapter = (new DatabaseAdapterFakeFactory())->create();
    }

    public function testCanCountElements(): void
    {
        $testElement = ['test' => 'test', 'id' => '75ae6d63-55fa-45df-b346-3be8eb921633'];

        $this->assertSame(0, $this->databaseAdapter->count(self::TEST_COLLECTION_NAME));

        $this->databaseAdapter->insertOne(self::TEST_COLLECTION_NAME, $testElement);

        $this->assertSame(1, $this->databaseAdapter->count(self::TEST_COLLECTION_NAME));
    }

    public function testCanFindAllElements(): void
    {
        $testElement1 = ['test' => 'test', 'id' => '75ae6d63-55fa-45df-b346-3be8eb921633'];
        $this->databaseAdapter->insertOne(self::TEST_COLLECTION_NAME, $testElement1);
        $testElement2 = ['test' => 'test', 'id' => 'eb64512a-80fa-4487-a0a7-b47d7b8927cb'];
        $this->databaseAdapter->insertOne(self::TEST_COLLECTION_NAME, $testElement2);

        $elements = $this->databaseAdapter->findAll(self::TEST_COLLECTION_NAME);

        $this->assertCount(2, $elements);
        $this->assertContains($testElement1, $elements);
        $this->assertContains($testElement2, $elements);
    }

    public function testCanFindOneElement(): void
    {
        $testElement1Id = '75ae6d63-55fa-45df-b346-3be8eb921633';
        $testElement1 = ['test' => 'test', 'id' => $testElement1Id];
        $this->databaseAdapter->insertOne(self::TEST_COLLECTION_NAME, $testElement1);
        $testElement2 = ['test' => 'test', 'id' => 'eb64512a-80fa-4487-a0a7-b47d7b8927cb'];
        $this->databaseAdapter->insertOne(self::TEST_COLLECTION_NAME, $testElement2);
        $foundElement = $this->databaseAdapter->findOne(self::TEST_COLLECTION_NAME, ['id' => $testElement1Id]);

        $this->assertSame($testElement1, $foundElement);
    }

    public function testCanInsertOneElement(): void
    {
        $testElementId = '75ae6d63-55fa-45df-b346-3be8eb921633';
        $testElement = [
            'test' => 'test',
            'id' => $testElementId
        ];

        $this->databaseAdapter->insertOne(self::TEST_COLLECTION_NAME, $testElement);
        $foundElement = $this->databaseAdapter->findOne(self::TEST_COLLECTION_NAME, ['id' => $testElementId]);

        $this->assertSame($testElement, $foundElement);
    }

    public function testCanUpdateOneElement(): void
    {
        $testElementId = '75ae6d63-55fa-45df-b346-3be8eb921633';
        $testElement = [
            'test' => 'test',
            'id' => $testElementId
        ];
        $changedTestValue = 'changedTest';

        $this->databaseAdapter->insertOne(self::TEST_COLLECTION_NAME, $testElement);
        $this->databaseAdapter->updateOne(self::TEST_COLLECTION_NAME, $testElementId, ['test' => $changedTestValue]);
        $foundElement = $this->databaseAdapter->findOne(self::TEST_COLLECTION_NAME, ['id' => $testElementId]);

        $this->assertSame($changedTestValue, $foundElement['test']);
    }

    public function testCanDeleteOneElement(): void
    {
        $testElementId = '75ae6d63-55fa-45df-b346-3be8eb921633';
        $testElement = [
            'test' => 'test',
            'id' => $testElementId
        ];

        $this->databaseAdapter->insertOne(self::TEST_COLLECTION_NAME, $testElement);
        $this->databaseAdapter->deleteOne(self::TEST_COLLECTION_NAME, $testElementId);
        $foundElement = $this->databaseAdapter->findOne(self::TEST_COLLECTION_NAME, ['id' => $testElementId]);

        $this->assertNull($foundElement);
    }

    public function tearDown(): void
    {
        $this->databaseAdapter->dropCollection(self::TEST_COLLECTION_NAME);
    }
}
