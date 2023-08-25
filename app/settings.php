<?php

declare(strict_types=1);

use Monolog\Level;
use Roots\WPConfig\Config;

use function Env\env;

$env = env('environment') ?: 'dev';

return [

    'environment'         => $env,
    'displayErrorDetails' => 'prod' !== $env, // Should be set to false in production
    'logError'            => true,
    'logErrorDetails'     => true,
    'logger'              => [
        'name'  => 'app',
        'path'  => Config::get('LOG_PATH') . '/app.log',
        'level' => Level::Debug,
    ],
    'attributes'          => [
        'sitename' => 'DailySitter',
        'errors'   => [],
    ],
    'templates'           => [
        'path'   => Config::get('TEMPLATE_PATH'),
        'layout' => 'components/layout',
    ],
];
