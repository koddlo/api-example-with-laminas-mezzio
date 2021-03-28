<?php

declare(strict_types=1);

namespace Customer\Middleware;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;

class UuidMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $uuid = Uuid::fromString((string) $request->getAttribute('customerId'));
        } catch (InvalidUuidStringException) {
            return new JsonResponse([
                'message' => 'Wrong customerId format'
            ], 400);
        }

        return $handler->handle(
            $request->withAttribute('customerId', $uuid)
        );
    }
}
