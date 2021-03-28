<?php

declare(strict_types=1);

namespace CustomerTest\Handler;

use Customer\Handler\UpdateCustomerHandler;
use Customer\Service\CustomerUpdater;
use CustomerTest\TestHelper\CustomerFakeRepository;
use CustomerTest\TestHelper\CustomerFixtureHelper;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class UpdateCustomerHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testCanHandleCustomerUpdate(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        $updateCustomerHandler = new UpdateCustomerHandler(new CustomerFakeRepository(), new CustomerUpdater());

        $request
            ->getAttribute('customerId')
            ->willReturn(Uuid::fromString('75ae6d63-55fa-45df-b346-3be8eb921633'));

        $request
            ->getParsedBody()
            ->willReturn((new CustomerFixtureHelper())->getTestCustomerData());

        $result = $updateCustomerHandler->handle($request->reveal());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertSame(200, $result->getStatusCode());
    }
}
