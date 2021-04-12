<?php

declare(strict_types=1);

namespace Error\Service;

use Laminas\Stratigility\Utils;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JsonErrorResponseGenerator
{
    private bool $isDebug;

    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

    public function __invoke(
        \Throwable $error,
        ServerRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        $message = 'An unexpected error occurred.';
        if ($this->isDebug) {
            $message .= sprintf(
                ' %s raised in file %s in line %d with message: %s',
                get_class($error),
                $error->getFile(),
                $error->getLine(),
                $error->getMessage()
            );
        }

        $response = $response->withHeader('Content-Type', 'application/json');
        $response = $response->withStatus(Utils::getStatusCode($error, $response));
        $response->getBody()->write(
            json_encode(['message' => $message])
        );

        return $response;
    }
}
