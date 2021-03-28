<?php

declare(strict_types=1);

namespace CustomerTest\Middleware;

use Customer\Middleware\UuidMiddleware;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Ramsey\Uuid\Uuid;

class UuidMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    /** @dataProvider provideWrongCustomerIds */
    public function testCannotHandleIdWithWrongFormat(mixed $customerId): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);

        $request
            ->getAttribute('customerId')
            ->willReturn($customerId);

        $middleware = new UuidMiddleware();
        $response = $middleware->process($request->reveal(), $handler->reveal());

        $this->assertSame(400, $response->getStatusCode());
    }

    public function testCanHandleUuid(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);

        $customerId = 'd2f3ae68-5f62-4825-80c6-07e5d9a71c25';

        $request
            ->getAttribute('customerId')
            ->willReturn($customerId);

        $request
            ->withAttribute('customerId', Uuid::fromString($customerId))
            ->willReturn($request->reveal());

        $handler
            ->handle($request->reveal())
            ->shouldBeCalled();

        $middleware = new UuidMiddleware();
        $middleware->process($request->reveal(), $handler->reveal());
    }

    public function provideWrongCustomerIds(): array
    {
        return [
            ['customerId' => 123],
            ['customerId' => '123'],
            ['customerId' => null],
            ['customerId' => 'd2f3ae68-5f6-482-80c-07e5d9a71c25']
        ];
    }
}
