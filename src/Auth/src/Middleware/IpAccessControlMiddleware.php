<?php

declare(strict_types=1);

namespace Auth\Middleware;

use Auth\Model\UserInterface;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Authentication\UserInterface as AuthUserInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Webmozart\Assert\Assert;

class IpAccessControlMiddleware implements MiddlewareInterface
{
    private AuthenticationInterface $auth;

    public function __construct(AuthenticationInterface $auth)
    {
        $this->auth = $auth;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var UserInterface $user */
        $user = $request->getAttribute(AuthUserInterface::class);
        Assert::isInstanceOf($user, UserInterface::class);

        $requestIp = $request->getServerParams()['REMOTE_ADDR'];
        if (!in_array($requestIp, $user->getIpAddresses())) {
            return $this->auth->unauthorizedResponse($request);
        }

        return $handler->handle(
            $request->withAttribute(UserInterface::class, $user)
        );
    }
}
