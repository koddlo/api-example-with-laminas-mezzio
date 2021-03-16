<?php

declare(strict_types=1);

namespace CustomerTest\Handler;

use Customer\DTO\Pagination;
use Customer\Handler\ReadAllCustomerHandler;
use Customer\Query\CountCustomerQuery;
use Customer\Query\GetAllCustomer;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;

class ReadAllCustomerHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testCanHandleAllCustomersRead(): void
    {
        $pagination = new Pagination();

        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var CountCustomerQuery|ObjectProphecy $countCustomerQuery */
        $countCustomerQuery = $this->prophesize(CountCustomerQuery::class);

        /** @var GetAllCustomer|ObjectProphecy $getAllCustomer */
        $getAllCustomer = $this->prophesize(GetAllCustomer::class);

        $countCustomerQuery
            ->execute($pagination)
            ->willReturn(0);

        $getAllCustomer
            ->execute($pagination)
            ->willReturn([]);

        $readAllCustomerHandler = new ReadAllCustomerHandler($countCustomerQuery->reveal(), $getAllCustomer->reveal());

        $result = $readAllCustomerHandler->handle($request->reveal());

        $this->assertInstanceOf(JsonResponse::class, $result);
        $this->assertSame(200, $result->getStatusCode());
    }
}
