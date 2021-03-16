<?php

declare(strict_types=1);

namespace Customer\Handler;

use Customer\Repository\CustomerRepositoryInterface;
use Customer\Service\CustomerUpdater;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

class UpdateCustomerHandler implements RequestHandlerInterface
{
    private CustomerRepositoryInterface $customerRepository;

    private CustomerUpdater $customerUpdater;

    public function __construct(CustomerRepositoryInterface $customerRepository, CustomerUpdater $customerUpdater)
    {
        $this->customerRepository = $customerRepository;
        $this->customerUpdater = $customerUpdater;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $customerId = $request->getAttribute('customerId');
        $customer = $this->customerRepository->findOneById(Uuid::fromString($customerId));

        $this->customerUpdater->update($customer, $request->getParsedBody());

        $this->customerRepository->save($customer);

        return new JsonResponse([
            'message' => 'Customer updated'
        ]);
    }
}
