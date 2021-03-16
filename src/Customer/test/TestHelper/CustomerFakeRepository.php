<?php

declare(strict_types=1);

namespace CustomerTest\TestHelper;

use Customer\Model\Customer;
use Customer\Repository\CustomerRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class CustomerFakeRepository implements CustomerRepositoryInterface
{
    public function save(Customer $customer): void
    {
    }

    public function delete(Customer $customer): void
    {
    }

    public function findOneById(UuidInterface $id): ?Customer
    {
        $customerFixture = new CustomerFixtureHelper();
        $customerData = $customerFixture->getTestCustomerData();
        $customerData['id'] = $id->toString();

        return unserialize($customerFixture->getSerializedCustomer($customerData));
    }
}
