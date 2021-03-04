<?php

declare(strict_types=1);

namespace Store\Service;

use MongoDB\Database;
use Store\Exception\InvalidDatabaseQueryException;
use Webmozart\Assert\Assert;

class DatabaseAdapter implements StoreInterface
{
    private Database $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function count(string $storeName, array $filters = [], array $options = []): int
    {
        try {
            $filters = $this->adaptFilters($filters);

            return $this->database
                ->selectCollection($storeName)
                ->countDocuments($filters, $options);
        } catch (\Throwable $throwable) {
            throw new InvalidDatabaseQueryException($throwable->getMessage());
        }
    }

    public function findAll(string $storeName, array $filters = [], array $options = []): array
    {
        try {
            $filters = $this->adaptFilters($filters);

            $documents = $this->database
                ->selectCollection($storeName)
                ->find($filters, $options)
                ->toArray();

            $arrayDocuments = [];
            /** @var \Traversable $document */
            foreach ($documents as $document) {
                Assert::isInstanceOf($document, \Traversable::class);

                $documentData = iterator_to_array($document);
                $documentData['id'] = $documentData['_id'];
                unset($documentData['_id']);

                $arrayDocuments[] = $documentData;
            }

            return $arrayDocuments;
        } catch (\Throwable $throwable) {
            throw new InvalidDatabaseQueryException($throwable->getMessage());
        }
    }

    public function findOne(string $storeName, array $filters = [], array $options = []): ?array
    {
        try {
            $filters = $this->adaptFilters($filters);

            /** @var \Traversable|null $document */
            $document = $this->database
                ->selectCollection($storeName)
                ->findOne($filters, $options);

            if ($document === null) {
                return null;
            }

            Assert::isInstanceOf($document, \Traversable::class);

            $documentData = iterator_to_array($document);
            $documentData['id'] = $documentData['_id'];
            unset($documentData['_id']);

            return $documentData;
        } catch (\Throwable $throwable) {
            throw new InvalidDatabaseQueryException($throwable->getMessage());
        }
    }

    public function insertOne(string $storeName, array $element, array $options = []): void
    {
        try {
            $element['_id'] = $element['_id'] ?? $element['id'] ?? null;
            unset($element['id']);

            $this->database
                ->selectCollection($storeName)
                ->insertOne($element, $options);
        } catch (\Throwable $throwable) {
            throw new InvalidDatabaseQueryException($throwable->getMessage());
        }
    }

    public function updateOne(string $storeName, string $elementId, array $changes, array $options = []): void
    {
        try {
            $this->database
                ->selectCollection($storeName)
                ->updateOne(
                    ['_id' => $elementId],
                    ['$set' => $changes],
                    $options
                );
        } catch (\Throwable $throwable) {
            throw new InvalidDatabaseQueryException($throwable->getMessage());
        }
    }

    public function deleteOne(string $storeName, string $elementId, array $options = []): void
    {
        try {
            $this->database
                ->selectCollection($storeName)
                ->deleteOne(['_id' => $elementId], $options);
        } catch (\Throwable $throwable) {
            throw new InvalidDatabaseQueryException($throwable->getMessage());
        }
    }

    public function dropCollection(string $storeName): void
    {
        try {
            $this->database->dropCollection($storeName);
        } catch (\Throwable $throwable) {
            throw new InvalidDatabaseQueryException($throwable->getMessage());
        }
    }

    private function adaptFilters(array $filters): array
    {
        if (!empty($filters['id'])) {
            $filters['_id'] = $filters['_id'] ?? $filters['id'] ?? null;
            unset($filters['id']);
        }

        return $filters;
    }
}
