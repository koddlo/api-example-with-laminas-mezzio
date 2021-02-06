<?php

declare(strict_types=1);

use Api\Handler\HomePageHandler;
use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (
    Application $app,
    MiddlewareFactory $factory,
    ContainerInterface $container
): void {
    $app->get('/', HomePageHandler::class, 'home');
};
