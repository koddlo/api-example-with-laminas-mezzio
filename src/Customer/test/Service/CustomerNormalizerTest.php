<?php

declare(strict_types=1);

namespace CustomerTest\Service;

use Customer\Model\Customer;
use Customer\Model\Job;
use Customer\Service\CustomerNormalizer;
use CustomerTest\TestHelper\CustomerFixtureHelper;
use PHPUnit\Framework\TestCase;

class CustomerNormalizerTest extends TestCase
{
    public function testCanNormalizeCustomer(): void
    {
        $customerData = (new CustomerFixtureHelper())->getTestCustomerData();
        $customer = new Customer($customerData['firstName'], $customerData['lastName'], $customerData['email']);
        $customer->setPhoneNumber($customerData['phoneNumber']);
        $customer->setJob(new Job($customerData['position'], $customerData['company']));

        $normalizedData = (new CustomerNormalizer())->normalize($customer);

        $this->assertSame($customerData['firstName'], $normalizedData['firstName']);
        $this->assertSame($customerData['lastName'], $normalizedData['lastName']);
        $this->assertSame($customerData['email'], $normalizedData['email']);
        $this->assertSame($customerData['position'], $normalizedData['position']);
        $this->assertSame($customerData['company'], $normalizedData['company']);
        $this->assertSame($customerData['phoneNumber'], $normalizedData['phoneNumber']);
    }

    public function testCanDenormalizeCustomer(): void
    {
        $customerData = (new CustomerFixtureHelper())->getTestCustomerData();
        $customer = (new CustomerNormalizer())->denormalize($customerData);

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertSame($customerData['id'], $customer->getIdString());
        $this->assertSame($customerData['firstName'], $customer->getFirstName());
        $this->assertSame($customerData['lastName'], $customer->getLastName());
        $this->assertSame($customerData['email'], $customer->getEmail());
        $this->assertSame($customerData['createdAt'], $customer->getCreatedAt()?->format('Y-m-d H:i'));
        $this->assertSame($customerData['position'], $customer->getJobPosition());
        $this->assertSame($customerData['company'], $customer->getJobCompany());
        $this->assertSame($customerData['phoneNumber'], $customer->getPhoneNumber());
    }
}
