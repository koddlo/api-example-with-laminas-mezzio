<?php

declare(strict_types=1);

namespace Customer\Handler;

use Customer\Query\CountCustomerQuery;
use Customer\Query\GetAllCustomer;
use Customer\DTO\Pagination;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ReadAllCustomerHandler implements RequestHandlerInterface
{
    private CountCustomerQuery $countCustomerQuery;

    private GetAllCustomer $getAllCustomer;

    public function __construct(CountCustomerQuery $countCustomerQuery, GetAllCustomer $getAllCustomer)
    {
        $this->countCustomerQuery = $countCustomerQuery;
        $this->getAllCustomer = $getAllCustomer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $pagination = new Pagination();
        $pagination->start = (int) ($request->getQueryParams()['start'] ?? $pagination->start);
        $pagination->limit = (int) ($request->getQueryParams()['limit'] ?? $pagination->limit);

        return new JsonResponse([
            'start' => $pagination->start,
            'limit' => $pagination->limit,
            'count' => $this->countCustomerQuery->execute($pagination),
            'customers' => $this->getAllCustomer->execute($pagination)
        ]);
    }
}
