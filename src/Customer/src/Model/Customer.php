<?php

declare(strict_types=1);

namespace Customer\Model;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class Customer
{
    private UuidInterface $id;

    private string $firstName;

    private string $lastName;

    private string $email;

    private ?string $phoneNumber = null;

    private ?Job $job = null;

    private \DateTimeImmutable $createdAt;

    public function __construct(
        string $firstName,
        string $lastName,
        string $email
    ) {
        $this->id = Uuid::uuid4();
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function __unserialize(array $customerData): void
    {
        Assert::notEmpty($customerData['id'] ?? null, 'Customer id is required.');
        Assert::notEmpty($customerData['firstName'] ?? null, 'Customer firstName is required.');
        Assert::notEmpty($customerData['lastName'] ?? null, 'Customer lastName is required.');
        Assert::notEmpty($customerData['email'] ?? null, 'Customer email is required.');
        Assert::notEmpty($customerData['createdAt'] ?? null, 'Customer createdAt is required.');

        $id = Uuid::isValid($customerData['id']);
        Assert::true($id, 'Customer id has wrong format.');

        $createdAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $customerData['createdAt']);
        Assert::isInstanceOf($createdAt, \DateTimeImmutable::class, 'Customer createdAt has wrong format.');

        $this->id = Uuid::fromString($customerData['id']);
        $this->firstName = $customerData['firstName'];
        $this->lastName = $customerData['lastName'];
        $this->email = $customerData['email'];
        $this->phoneNumber = $customerData['phoneNumber'] ?? null;
        $this->createdAt = \DateTimeImmutable::createFromFormat('Y-m-d H:i', $customerData['createdAt']);

        $this->job = null;
        if (!empty($customerData['position']) && !empty($customerData['company'])) {
            $this->job = new Job($customerData['position'], $customerData['company']);
        }
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getIdString(): string
    {
        return $this->id->toString();
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getJobPosition(): ?string
    {
        return $this->job?->getPosition();
    }

    public function getJobCompany(): ?string
    {
        return $this->job?->getCompany();
    }

    public function setJob(?Job $job): void
    {
        $this->job = $job;
    }
}
