<?php

declare(strict_types=1);

namespace Customer\Factory;

use Customer\Middleware\CustomerValidationMiddleware;
use Customer\Service\CustomerValidator;
use Laminas\InputFilter\InputFilterPluginManager;
use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

class CustomerValidationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): CustomerValidationMiddleware
    {
        /** @var InputFilterPluginManager $pluginManager */
        $pluginManager = $container->get(InputFilterPluginManager::class);
        /** @var CustomerValidator $customerValidator */
        $customerValidator = $pluginManager->get(CustomerValidator::class);
        Assert::isInstanceOf($customerValidator, CustomerValidator::class);

        return new CustomerValidationMiddleware(
            $customerValidator
        );
    }
}
