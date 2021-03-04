<?php

declare(strict_types=1);

namespace Store\Service;

use Store\Exception\InvalidDatabaseQueryException;

interface StoreInterface
{
    /**
     * @param string $storeName
     * @param array $filters
     * @param array $options
     * @return integer
     * @throws InvalidDatabaseQueryException
     */
    public function count(string $storeName, array $filters = [], array $options = []): int;

    /**
     * @param string $storeName
     * @param array $filters
     * @param array $options
     * @return array
     * @throws InvalidDatabaseQueryException
     */
    public function findAll(string $storeName, array $filters = [], array $options = []): array;

    /**
     * @param string $storeName
     * @param array $filters
     * @param array $options
     * @return array|null
     * @throws InvalidDatabaseQueryException
     */
    public function findOne(string $storeName, array $filters = [], array $options = []): ?array;

    /**
     * @param string $storeName
     * @param array $element
     * @param array $options
     * @return void
     * @throws InvalidDatabaseQueryException
     */
    public function insertOne(string $storeName, array $element, array $options = []): void;

    /**
     * @param string $storeName
     * @param string $elementId
     * @param array $changes
     * @param array $options
     * @return void
     * @throws InvalidDatabaseQueryException
     */
    public function updateOne(string $storeName, string $elementId, array $changes, array $options = []): void;

    /**
     * @param string $storeName
     * @param string $elementId
     * @param array $options
     * @return void
     * @throws InvalidDatabaseQueryException
     */
    public function deleteOne(string $storeName, string $elementId, array $options = []): void;
}
