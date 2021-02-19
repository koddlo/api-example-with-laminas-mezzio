<?php

declare(strict_types=1);

namespace AuthTest\Middleware;

use Auth\Middleware\IpAccessControlMiddleware;
use Auth\Model\User;
use Auth\Model\UserInterface;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\UserInterface as AuthUserInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class IpAccessControlMiddlewareTest extends TestCase
{
    use ProphecyTrait;

    public function testCannotAccessWithWrongIpAddress(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);

        /** @var AuthenticationInterface|ObjectProphecy $auth */
        $auth = $this->prophesize(AuthenticationInterface::class);

        $request
            ->getAttribute(AuthUserInterface::class)
            ->willReturn(
                new User('testId', 'hashedPassword', ['196.168.0.1'])
            );

        $request
            ->getServerParams()
            ->willReturn([
                'REMOTE_ADDR' => '127.0.0.1'
            ]);

        $auth
            ->unauthorizedResponse($request->reveal())
            ->shouldBeCalled();

        $middleware = new IpAccessControlMiddleware($auth->reveal());
        $middleware->process($request->reveal(), $handler->reveal());
    }

    public function testCanAccessWithAllowedIpAddress(): void
    {
        /** @var ServerRequestInterface|ObjectProphecy $request */
        $request = $this->prophesize(ServerRequestInterface::class);

        /** @var RequestHandlerInterface|ObjectProphecy $handler */
        $handler = $this->prophesize(RequestHandlerInterface::class);

        /** @var AuthenticationInterface|ObjectProphecy $auth */
        $auth = $this->prophesize(AuthenticationInterface::class);

        $user = new User('testId', 'hashedPassword', ['127.0.0.1']);

        $request
            ->getAttribute(AuthUserInterface::class)
            ->willReturn($user);

        $request
            ->getServerParams()
            ->willReturn([
                'REMOTE_ADDR' => '127.0.0.1'
            ]);

        $request
            ->withAttribute(UserInterface::class, $user)
            ->willReturn($request->reveal());

        $auth
            ->unauthorizedResponse($request->reveal())
            ->shouldNotBeenCalled();

        $handler
            ->handle($request->reveal())
            ->shouldBeCalled();

        $middleware = new IpAccessControlMiddleware($auth->reveal());
        $middleware->process($request->reveal(), $handler->reveal());
    }
}
