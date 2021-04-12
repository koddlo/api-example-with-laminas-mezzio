<?php

declare(strict_types=1);

namespace Error;

use Laminas\Stratigility\Middleware\ErrorHandler;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies()
        ];
    }

    public function getDependencies(): array
    {
        return [
            'aliases' => [
                Service\LoggerInterface::class => Service\FileErrorLogger::class
            ],
            'factories' => [
                ErrorHandler::class => Factory\CustomErrorHandlerFactory::class,
                Service\JsonErrorResponseGenerator::class => Factory\JsonErrorResponseGeneratorFactory::class,
                Service\FileErrorLogger::class => Factory\FileErrorLoggerFactory::class
            ],
            'delegators' => [
                ErrorHandler::class => [
                    Factory\ErrorHandlerDelegatorFactory::class
                ]
            ]
        ];
    }
}
