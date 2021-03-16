<?php

declare(strict_types=1);

namespace Customer\Handler;

use Customer\Repository\CustomerRepositoryInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

class DeleteCustomerHandler implements RequestHandlerInterface
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $customerId = $request->getAttribute('customerId');
        $customer = $this->customerRepository->findOneById(Uuid::fromString($customerId));

        $this->customerRepository->delete($customer);

        return new JsonResponse([
            'message' => 'Customer deleted'
        ]);
    }
}
