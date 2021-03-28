<?php

declare(strict_types=1);

namespace CustomerTest\Middleware;

use Customer\Middleware\CustomerExistenceMiddleware;
use Customer\Query\GetOneCustomerById;
use CustomerTest\TestHelper\CustomerFixtureHelper;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

class CustomerExistenceMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    public function testCannotHandleNonexistentCustomer(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);

        /** @var GetOneCustomerById|ObjectProphecy $query */
        $query = $this->prophesize(GetOneCustomerById::class);

        $customerId = Uuid::fromString('d2f3ae68-5f62-4825-80c6-07e5d9a71c25');

        $request
            ->getAttribute('customerId')
            ->willReturn($customerId);

        $query
            ->execute($customerId)
            ->willReturn(null);

        $middleware = new CustomerExistenceMiddleware($query->reveal());
        $response = $middleware->process($request->reveal(), $handler->reveal());

        $this->assertSame(400, $response->getStatusCode());
    }

    public function testCanHandleExistentCustomer(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);

        /** @var GetOneCustomerById|ObjectProphecy $query */
        $query = $this->prophesize(GetOneCustomerById::class);

        $customerId = Uuid::fromString('d2f3ae68-5f62-4825-80c6-07e5d9a71c25');
        $customer = (new CustomerFixtureHelper())->getTestCustomerData();

        $request
            ->getAttribute('customerId')
            ->willReturn($customerId);

        $query
            ->execute($customerId)
            ->willReturn($customer);

        $handler
            ->handle($request->reveal())
            ->shouldBeCalled();

        $middleware = new CustomerExistenceMiddleware($query->reveal());
        $middleware->process($request->reveal(), $handler->reveal());
    }
}
