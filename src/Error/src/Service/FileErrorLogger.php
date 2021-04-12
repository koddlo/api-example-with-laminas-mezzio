<?php

declare(strict_types=1);

namespace Error\Service;

class FileErrorLogger implements LoggerInterface
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function log(string $message): void
    {
        $log  = sprintf(
            'Date: %s, Message: %s',
            (new \DateTime())->format('d.m.Y H:i:s'),
            $message
        );

        file_put_contents($this->filePath, $log . PHP_EOL, FILE_APPEND);
    }
}
