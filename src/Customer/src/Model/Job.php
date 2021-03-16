<?php

declare(strict_types=1);

namespace Customer\Model;

class Job
{
    private string $position;

    private string $company;

    public function __construct(string $position, string $company)
    {
        $this->position = $position;
        $this->company = $company;
    }

    public function getPosition(): string
    {
        return $this->position;
    }

    public function getCompany(): string
    {
        return $this->company;
    }
}
