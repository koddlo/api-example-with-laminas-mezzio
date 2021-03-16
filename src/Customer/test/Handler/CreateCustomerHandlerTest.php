<?php

declare(strict_types=1);

namespace CustomerTest\Handler;

use Customer\Handler\CreateCustomerHandler;
use CustomerTest\TestHelper\CustomerFakeRepository;
use CustomerTest\TestHelper\CustomerFixtureHelper;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;

class CreateCustomerHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testCanHandleCustomerCreation(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        $createCustomerHandler = new CreateCustomerHandler(new CustomerFakeRepository());

        $request
            ->getParsedBody()
            ->willReturn((new CustomerFixtureHelper())->getTestCustomerData());

        $result = $createCustomerHandler->handle($request->reveal());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertSame(201, $result->getStatusCode());
    }
}
