<?php

declare(strict_types=1);

namespace Customer\Query;

use Ramsey\Uuid\UuidInterface;
use Store\Service\StoreInterface;

class GetOneCustomerById implements QueryMarkerInterface
{
    private const STORE_NAME = 'customer';

    private StoreInterface $store;

    public function __construct(StoreInterface $store)
    {
        $this->store = $store;
    }

    public function execute(UuidInterface $id): ?array
    {
        return $this->store->findOne(self::STORE_NAME, ['id' => $id->toString()]);
    }
}
