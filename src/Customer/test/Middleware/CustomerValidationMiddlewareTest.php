<?php

declare(strict_types=1);

namespace CustomerTest\Middleware;

use Customer\Middleware\CustomerValidationMiddleware;
use Customer\Service\CustomerValidator;
use CustomerTest\TestHelper\CustomerFixtureHelper;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CustomerValidationMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    public function testCannotHandleInvalidCustomerData(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);

        $request
            ->getMethod()
            ->willReturn('POST');

        $request
            ->getParsedBody()
            ->willReturn([]);

        $validator = new CustomerValidator();
        $validator->init();
        $middleware = new CustomerValidationMiddleware($validator);
        $response = $middleware->process($request->reveal(), $handler->reveal());

        $this->assertSame(400, $response->getStatusCode());
    }

    public function testCanHandleValidCustomerData(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);

        $customerData = (new CustomerFixtureHelper())->getTestCustomerData();

        $request
            ->getMethod()
            ->willReturn('POST');

        $request
            ->getParsedBody()
            ->willReturn($customerData);

        $request
            ->withParsedBody(Argument::any())
            ->willReturn($request->reveal());

        $handler
            ->handle($request->reveal())
            ->shouldBeCalled();

        $validator = new CustomerValidator();
        $validator->init();
        $middleware = new CustomerValidationMiddleware($validator);
        $middleware->process($request->reveal(), $handler->reveal());
    }
}
