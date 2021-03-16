<?php

declare(strict_types=1);

namespace CustomerTest\Model;

use Customer\Model\Customer;
use CustomerTest\TestHelper\CustomerFixtureHelper;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testCanUnserializeCustomer(): void
    {
        $customerFixture = new CustomerFixtureHelper();
        $serializedCustomer = $customerFixture->getSerializedCustomer($customerFixture->getTestCustomerData());

        $this->assertInstanceOf(Customer::class, unserialize($serializedCustomer));
    }

    /** @dataProvider provideWrongCustomersData */
    public function testCannotUnserializeUsingWrongCustomerData(array $customerData): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $serializedCustomer = (new CustomerFixtureHelper())->getSerializedCustomer($customerData);

        unserialize($serializedCustomer);
    }

    public function provideWrongCustomersData(): array
    {
        return (new CustomerFixtureHelper())->getWrongCustomersData();
    }
}
