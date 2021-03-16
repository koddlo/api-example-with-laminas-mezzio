<?php

declare(strict_types=1);

namespace CustomerTest\TestHelper;

use Customer\Model\Customer;

class CustomerFixtureHelper
{
    public function getMinimalCustomer(): Customer
    {
        return new Customer('Jane', 'Doe', 'jane.doe@koddlo.pl');
    }

    public function getTestCustomerData(): array
    {
        return [
            'id' => 'd2f3ae68-5f62-4825-80c6-07e5d9a71c25',
            'firstName' => 'Jane',
            'lastName' => 'Doe',
            'email' => 'jane.doe@koddlo.pl',
            'createdAt' => '2020-03-02 22:20',
            'position' => 'PHP Developer',
            'company' => 'Koddlo',
            'phoneNumber' => '123456789'
        ];
    }

    public function getSerializedCustomer(array $customerData): string
    {
        return sprintf(
            'O:%d:"%s"%s',
            strlen(Customer::class),
            Customer::class,
            strstr(serialize($customerData), ':')
        );
    }

    public function getWrongCustomersData(): array
    {
        return [
            [
                'noId' => [
                    'firstName' => 'Jane',
                    'lastName' => 'Doe',
                    'email' => 'jane.doe@koddlo.pl',
                    'createdAt' => '2020-03-02 22:20',
                ]
            ],
            [
                'noFirstName' => [
                    'id' => 'd2f3ae68-5f62-4825-80c6-07e5d9a71c25',
                    'lastName' => 'Doe',
                    'email' => 'jane.doe@koddlo.pl',
                    'createdAt' => '2020-03-02 22:20',
                ]
            ],
            [
                'noLastName' => [
                    'id' => 'd2f3ae68-5f62-4825-80c6-07e5d9a71c25',
                    'firstName' => 'Jane',
                    'email' => 'jane.doe@koddlo.pl',
                    'createdAt' => '2020-03-02 22:20',
                ]
            ],
            [
                'noEmail' => [
                    'id' => 'd2f3ae68-5f62-4825-80c6-07e5d9a71c25',
                    'firstName' => 'Jane',
                    'lastName' => 'Doe',
                    'createdAt' => '2020-03-02 22:20',
                ]
            ],
            [
                'noCreatedAt' => [
                    'id' => 'd2f3ae68-5f62-4825-80c6-07e5d9a71c25',
                    'firstName' => 'Jane',
                    'lastName' => 'Doe',
                    'email' => 'jane.doe@koddlo.pl',
                ]
            ],
            [
                'wrongId' => [
                    'id' => 'wrongId',
                    'firstName' => 'Jane',
                    'lastName' => 'Doe',
                    'email' => 'jane.doe@koddlo.pl',
                    'createdAt' => '2020-03-02 22:20',
                ]
            ],
            [
                'wrongCreatedAt' => [
                    'id' => 'wrongId',
                    'firstName' => 'Jane',
                    'lastName' => 'Doe',
                    'email' => 'jane.doe@koddlo.pl',
                    'createdAt' => 'wrongCreatedAt',
                ]
            ]
        ];
    }
}
