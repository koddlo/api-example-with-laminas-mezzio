<?php

declare(strict_types=1);

namespace Customer\Handler;

use Customer\Factory\CustomerFactory;
use Customer\Repository\CustomerRepositoryInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CreateCustomerHandler implements RequestHandlerInterface
{
    private CustomerRepositoryInterface $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $customer = (new CustomerFactory())->fromArray($request->getParsedBody());

        $this->customerRepository->save($customer);

        return new JsonResponse([
            'message' => 'Customer created'
        ], 201);
    }
}
