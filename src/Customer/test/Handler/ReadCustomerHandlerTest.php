<?php

declare(strict_types=1);

namespace CustomerTest\Handler;

use Customer\Handler\ReadCustomerHandler;
use Customer\Query\GetOneCustomerById;
use CustomerTest\TestHelper\CustomerFixtureHelper;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class ReadCustomerHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testCanHandleCustomerRead(): void
    {
        $testCustomerId = Uuid::fromString('75ae6d63-55fa-45df-b346-3be8eb921633');
        $customerData = (new CustomerFixtureHelper())->getTestCustomerData();
        $customerData['id'] = $testCustomerId;

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var GetOneCustomerById|ObjectProphecy $getOneCustomerById */
        $getOneCustomerById = $this->prophesize(GetOneCustomerById::class);

        $getOneCustomerById
            ->execute($testCustomerId)
            ->willReturn($customerData);

        $readCustomerHandler = new ReadCustomerHandler($getOneCustomerById->reveal());

        $request
            ->getAttribute('customerId')
            ->willReturn($testCustomerId);

        $result = $readCustomerHandler->handle($request->reveal());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertSame(200, $result->getStatusCode());
    }
}
