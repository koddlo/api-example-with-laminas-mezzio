<?php

declare(strict_types=1);

use Auth\Middleware\IpAccessControlMiddleware;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Mezzio\Authentication\AuthenticationMiddleware;
use Mezzio\Cors\Middleware\CorsMiddleware;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\MiddlewareFactory;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;
use Psr\Container\ContainerInterface;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->pipe(ErrorHandler::class);

    $app->pipe(CorsMiddleware::class);

    $app->pipe(ServerUrlMiddleware::class);
    $app->pipe('/api/v1', AuthenticationMiddleware::class);
    $app->pipe('/api/v1', IpAccessControlMiddleware::class);
    $app->pipe(RouteMiddleware::class);

    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(MethodNotAllowedMiddleware::class);

    $app->pipe(BodyParamsMiddleware::class);
    $app->pipe(UrlHelperMiddleware::class);

    $app->pipe(DispatchMiddleware::class);

    $app->pipe(NotFoundHandler::class);
};
