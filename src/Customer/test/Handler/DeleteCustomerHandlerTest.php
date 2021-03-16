<?php

declare(strict_types=1);

namespace CustomerTest\Handler;

use Customer\Handler\DeleteCustomerHandler;
use CustomerTest\TestHelper\CustomerFakeRepository;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;

class DeleteCustomerHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testCanHandleCustomerDeletion(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        $deleteCustomerHandler = new DeleteCustomerHandler(new CustomerFakeRepository());

        $request
            ->getAttribute('customerId')
            ->willReturn('75ae6d63-55fa-45df-b346-3be8eb921633');

        $result = $deleteCustomerHandler->handle($request->reveal());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertSame(200, $result->getStatusCode());
    }
}
