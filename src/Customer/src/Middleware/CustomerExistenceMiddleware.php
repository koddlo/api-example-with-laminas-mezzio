<?php

declare(strict_types=1);

namespace Customer\Middleware;

use Customer\Query\GetOneCustomerById;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CustomerExistenceMiddleware implements MiddlewareInterface
{
    private GetOneCustomerById $getOneCustomerById;

    public function __construct(GetOneCustomerById $getOneCustomerById)
    {
        $this->getOneCustomerById = $getOneCustomerById;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (empty($this->getOneCustomerById->execute($request->getAttribute('customerId')))) {
            return new JsonResponse([
                'message' => 'Customer with this customerId does not exist'
            ], 400);
        }

        return $handler->handle($request);
    }
}
