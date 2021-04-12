<?php

declare(strict_types=1);

namespace Error\Factory;

use Error\Service\FileErrorLogger;
use Psr\Container\ContainerInterface;

class FileErrorLoggerFactory
{
    public function __invoke(ContainerInterface $container): FileErrorLogger
    {
        return new FileErrorLogger(APPLICATION_PATH . '/../data/log/error.log');
    }
}
