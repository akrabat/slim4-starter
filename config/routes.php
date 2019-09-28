<?php

declare(strict_types=1);

use App\Handler\HomePageHandler;
use Slim\App;

return function (App $app) {
    $app->get('/[{name}]', HomePageHandler::class)->setName('home');
};
