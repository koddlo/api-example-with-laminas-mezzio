<?php

declare(strict_types=1);

namespace CustomerTest\Service;

use Customer\Model\Job;
use Customer\Service\CustomerUpdater;
use CustomerTest\TestHelper\CustomerFixtureHelper;
use PHPUnit\Framework\TestCase;

class CustomerUpdaterTest extends TestCase
{
    public function testCanUpdateLastName(): void
    {
        $customer = (new CustomerFixtureHelper())->getMinimalCustomer();
        $customerUpdater = new CustomerUpdater();

        $customerUpdater->update($customer, ['lastName' => 'Shmoe']);

        $this->assertSame('Shmoe', $customer->getLastName());
    }

    public function testCanUpdateEmail(): void
    {
        $customer = (new CustomerFixtureHelper())->getMinimalCustomer();
        $customerUpdater = new CustomerUpdater();

        $customerUpdater->update($customer, ['email' => 'jdoe@koddlo.pl']);

        $this->assertSame('jdoe@koddlo.pl', $customer->getEmail());
    }

    public function testCanUpdatePhoneNumber(): void
    {
        $customer = (new CustomerFixtureHelper())->getMinimalCustomer();
        $customerUpdater = new CustomerUpdater();

        $customerUpdater->update($customer, ['phoneNumber' => '999999999']);

        $this->assertSame('999999999', $customer->getPhoneNumber());
    }

    public function testCanUpdatePosition(): void
    {
        $customer = (new CustomerFixtureHelper())->getMinimalCustomer();
        $customer->setJob(new Job('Junior PHP Developer', 'Koddlo'));
        $customerUpdater = new CustomerUpdater();

        $customerUpdater->update($customer, ['position' => 'PHP Developer']);

        $this->assertSame('PHP Developer', $customer->getJobPosition());
    }

    public function testCanUpdateCompany(): void
    {
        $customer = (new CustomerFixtureHelper())->getMinimalCustomer();
        $customer->setJob(new Job('Junior PHP Developer', 'Koddlo'));
        $customerUpdater = new CustomerUpdater();

        $customerUpdater->update($customer, ['company' => 'Laminas']);

        $this->assertSame('Laminas', $customer->getJobCompany());
    }
}
