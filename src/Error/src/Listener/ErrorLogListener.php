<?php

declare(strict_types=1);

namespace Error\Listener;

use Error\Service\LoggerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ErrorLogListener
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(\Throwable $error, ServerRequestInterface $request, ResponseInterface $response): void
    {
        $log = sprintf(
            '%s raised in file %s in line %d with message: %s',
            get_class($error),
            $error->getFile(),
            $error->getLine(),
            $error->getMessage()
        );

        $this->logger->log($log);
    }
}
