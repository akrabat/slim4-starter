<?php

declare(strict_types=1);

use Monolog\Logger;

return static function(string $appEnv) {
    $settings =  [
        'app_env' => $appEnv,
        'di_compilation_path' => __DIR__ . '/../var/cache',
        'display_error_details' => false,
        'log_errors' => true,

        'logger' => [
            'name' => 'slim-app',
            'path' => 'php://stderr',
            'level' => Logger::DEBUG,
        ],
    ];

    if ($appEnv === 'DEVELOPMENT') {
        // Overrides for development mode
        $settings['di_compilation_path'] = '';
        $settings['display_error_details'] = true;
        $settings['logger']['path'] = __DIR__ . '/../var/log/app.log';
    }

    return $settings;
};
