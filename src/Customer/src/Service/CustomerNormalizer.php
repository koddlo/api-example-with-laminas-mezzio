<?php

declare(strict_types=1);

namespace Customer\Service;

use Customer\Model\Customer;

class CustomerNormalizer
{
    public function normalize(Customer $customer): array
    {
        return [
            'id' => $customer->getIdString(),
            'firstName' => $customer->getFirstName(),
            'lastName' => $customer->getLastName(),
            'email' => $customer->getEmail(),
            'createdAt' => $customer->getCreatedAt()?->format('Y-m-d H:i'),
            'phoneNumber' => $customer->getPhoneNumber(),
            'position' => $customer->getJobPosition(),
            'company' => $customer->getJobCompany()
        ];
    }

    public function denormalize(array $customerData): Customer
    {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen(Customer::class),
            Customer::class,
            strstr(serialize($customerData), ':')
        ));
    }
}
