<?php

declare(strict_types=1);

use App\Support\Env;
use Psr\Log\LoggerInterface;
use Slim\App;

return static function (App $app, Env $env) {
    /** @var Psr\Container\ContainerInterface $container */
    $container = $app->getContainer();

    // The last middleware layer added is the first to be executed.
    // This means that bottom of this list runs first (is on the outside) and the one at the top, runs last as it
    // is the inner most one.
    $app->addBodyParsingMiddleware();
    $app->addErrorMiddleware(
        displayErrorDetails: $env->getBool('DISPLAY_ERROR_DETAILS'),
        logErrors: $env->getBool('LOG_ERRORS', true),
        logErrorDetails: true,
        logger: $container->get(LoggerInterface::class),
    );
};
