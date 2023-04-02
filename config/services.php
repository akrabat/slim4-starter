<?php

declare(strict_types=1);

use App\Handler\HomePageHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use function DI\autowire;

return [
    LoggerInterface::class => function (ContainerInterface $c): LoggerInterface {
        $handlers = (PHP_SAPI === 'cli')
            ? [new StreamHandler('php://stderr')]
            : [new ErrorLogHandler()];

        return new Logger('app', $handlers, [
            $c->get(UidProcessor::class)
        ]);
    },

    // Classes that are autowired are listed so that PHP-DI compilation will take them into account
    UidProcessor::class => autowire(),
    HomePageHandler::class => autowire(),
];
