<?php

declare(strict_types=1);

namespace Customer\Repository;

use Customer\Model\Customer;
use Customer\Service\CustomerNormalizer;
use Ramsey\Uuid\UuidInterface;
use Store\Service\StoreInterface;

class CustomerRepository implements CustomerRepositoryInterface
{
    private const STORE_NAME = 'customer';

    private StoreInterface $store;

    private CustomerNormalizer $normalizer;

    public function __construct(StoreInterface $store, CustomerNormalizer $normalizer)
    {
        $this->store = $store;
        $this->normalizer = $normalizer;
    }

    public function save(Customer $customer): void
    {
        if (!$this->findOneById($customer->getId())) {
            $this->store->insertOne(self::STORE_NAME, $this->normalizer->normalize($customer));

            return;
        }

        $this->store->updateOne(self::STORE_NAME, $customer->getIdString(), $this->normalizer->normalize($customer));
    }

    public function delete(Customer $customer): void
    {
        $this->store->deleteOne(self::STORE_NAME, $customer->getIdString());
    }

    public function findOneById(UuidInterface $id): ?Customer
    {
        $customerData = $this->store->findOne(self::STORE_NAME, ['id' => $id->toString()]);

        return !empty($customerData) ? $this->normalizer->denormalize($customerData) : null;
    }
}
