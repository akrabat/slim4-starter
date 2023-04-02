<?php

declare(strict_types=1);

use App\Support\Env;
use Psr\Log\LoggerInterface;
use Slim\App;

return static function (App $app, Env $env) {
    /** @var Psr\Container\ContainerInterface $container */
    $container = $app->getContainer();

    $app->addErrorMiddleware(
        displayErrorDetails: $env->getBool('DISPLAY_ERROR_DETAILS'),
        logErrors: $env->getBool('LOG_ERRORS', true),
        logErrorDetails: true,
        logger: $container->get(LoggerInterface::class),
    );

    $app->addBodyParsingMiddleware();
    $app->addRoutingMiddleware();
};
