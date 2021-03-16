<?php

declare(strict_types=1);

namespace Customer\Repository;

use Customer\Model\Customer;
use Ramsey\Uuid\UuidInterface;

interface CustomerRepositoryInterface
{
    public function save(Customer $customer): void;

    public function delete(Customer $customer): void;

    public function findOneById(UuidInterface $id): ?Customer;
}
