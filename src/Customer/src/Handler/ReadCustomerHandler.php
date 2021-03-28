<?php

declare(strict_types=1);

namespace Customer\Handler;

use Customer\Query\GetOneCustomerById;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReadCustomerHandler implements RequestHandlerInterface
{
    private GetOneCustomerById $getOneCustomerById;

    public function __construct(GetOneCustomerById $getOneCustomerById)
    {
        $this->getOneCustomerById = $getOneCustomerById;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse(
            $this->getOneCustomerById->execute($request->getAttribute('customerId'))
        );
    }
}
