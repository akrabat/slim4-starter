<?php

declare(strict_types=1);

use App\Support\Env;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestHandler;

require __DIR__ . '/../vendor/autoload.php';

/**
 * @throws Exception
 */
(function() {
    // Load environment
    $env = new Env(__DIR__ . '/..');

    // Set up dependencies
    $containerBuilder = new ContainerBuilder();
    if ($env->get('DI_COMPILATION_PATH')) {
        // Note: clear out compiled DI definitions on new deploy
        // See https://php-di.org/doc/performances.html#deployment-in-production
        $containerBuilder->enableCompilation($env->get('DI_COMPILATION_PATH'));
    }
    $containerBuilder->addDefinitions(__DIR__.'/../config/services.php');

    // Create app
    AppFactory::setContainer($containerBuilder->build());
    $app = AppFactory::create();

    // Assign matched route arguments to Request attributes for PSR-15 handlers
    $app->getRouteCollector()->setDefaultInvocationStrategy(new RequestHandler(true));

    // Register middleware
    (require __DIR__.'/../config/middleware.php')($app, $env);

    // Register routes
    (require __DIR__.'/../config/routes.php')($app);

    // Run app
    $app->run();
})();

