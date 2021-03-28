<?php

declare(strict_types=1);

namespace Customer\Middleware;

use Customer\Service\CustomerValidator;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CustomerValidationMiddleware implements MiddlewareInterface
{
    private CustomerValidator $customerValidator;

    public function __construct(CustomerValidator $customerValidator)
    {
        $this->customerValidator = $customerValidator;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->customerValidator->setRequired($request->getMethod() === 'POST');
        $this->customerValidator->setData($request->getParsedBody());

        if (!$this->customerValidator->isValid()) {
            return new JsonResponse([
                'message' => $this->customerValidator->getErrorMessage() ?? 'Unexpected validation error'
            ], 400);
        }

        return $handler->handle(
            $request->withParsedBody($this->customerValidator->getValues())
        );
    }
}
