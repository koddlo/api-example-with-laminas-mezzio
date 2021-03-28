<?php

declare(strict_types=1);

namespace Customer\Handler;

use Customer\Repository\CustomerRepositoryInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DeleteCustomerHandler implements RequestHandlerInterface
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $customer = $this->customerRepository->findOneById($request->getAttribute('customerId'));

        $this->customerRepository->delete($customer);

        return new JsonResponse([
            'message' => 'Customer deleted'
        ]);
    }
}
