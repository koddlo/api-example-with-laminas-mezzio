<?php

declare(strict_types=1);

namespace Error\Service;

interface LoggerInterface
{
    public function log(string $message): void;
}
