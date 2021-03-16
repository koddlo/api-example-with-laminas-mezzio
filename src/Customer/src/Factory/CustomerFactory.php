<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Model\Customer;
use Customer\Model\Job;
use Webmozart\Assert\Assert;

class CustomerFactory
{
    public function fromArray(array $customerData): Customer
    {
        Assert::notEmpty($customerData['firstName'] ?? null, 'Customer firstName is required.');
        Assert::notEmpty($customerData['lastName'] ?? null, 'Customer lastName is required.');
        Assert::notEmpty($customerData['email'] ?? null, 'Customer email is required.');

        $customer = new Customer($customerData['firstName'], $customerData['lastName'], $customerData['email']);
        $customer->setPhoneNumber($customerData['phoneNumber'] ?? null);
        if (!empty($customerData['position']) && !empty($customerData['company'])) {
            $customer->setJob(new Job($customerData['position'], $customerData['company']));
        }

        return $customer;
    }
}
