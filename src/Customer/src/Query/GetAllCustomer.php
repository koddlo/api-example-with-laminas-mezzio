<?php

declare(strict_types=1);

namespace Customer\Query;

use Customer\DTO\Pagination;
use Store\Service\StoreInterface;

class GetAllCustomer implements QueryMarkerInterface
{
    private const STORE_NAME = 'customer';

    private StoreInterface $store;

    public function __construct(StoreInterface $store)
    {
        $this->store = $store;
    }

    public function execute(?Pagination $pagination = null): array
    {
        $options = [];
        if ($pagination !== null) {
            $options = [
                'skip' => $pagination->start,
                'limit' => $pagination->limit
            ];
        }

        return $this->store->findAll(self::STORE_NAME, [], $options);
    }
}
