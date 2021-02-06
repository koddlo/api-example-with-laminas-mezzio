<?php

declare(strict_types=1);

namespace ApiTest\Handler;

use Api\Handler\HomePageHandler;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;

class HomePageHandlerTest extends TestCase
{
    use ProphecyTrait;

    public function testHomeActionReturnJson(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        $handler = new HomePageHandler();
        $response = $handler->handle($request->reveal());

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
