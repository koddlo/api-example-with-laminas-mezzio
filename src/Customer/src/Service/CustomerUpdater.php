<?php

declare(strict_types=1);

namespace Customer\Service;

use Customer\Model\Customer;
use Customer\Model\Job;

class CustomerUpdater
{
    public function update(Customer $customer, array $changes): void
    {
        if (!empty($changes['lastName'])) {
            $customer->setLastName($changes['lastName']);
        }

        if (!empty($changes['email'])) {
            $customer->setEmail($changes['email']);
        }

        if (array_key_exists('phoneNumber', $changes)) {
            $customer->setPhoneNumber($changes['phoneNumber']);
        }

        $jobPosition = $changes['position'] ?? $customer->getJobPosition() ?? null;
        $jobCompany = $changes['company'] ?? $customer->getJobCompany() ?? null;
        if (!empty($jobPosition) && !empty($jobCompany)) {
            $customer->setJob(new Job($jobPosition, $jobCompany));
        }
    }
}
