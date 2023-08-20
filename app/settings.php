<?php

declare(strict_types=1);

use Monolog\Level;
use NGSOFT\Container\ContainerInterface;
use Roots\WPConfig\Config;

return function (ContainerInterface $container)
{
    $container->set('settings', [
        'displayErrorDetails' => true, // Should be set to false in production
        'logError'            => true,
        'logErrorDetails'     => true,
        'logger'              => [
            'name'  => 'app',
            'path'  => Config::get('LOG_PATH') . '/app.log',
            'level' => Level::Debug,
        ],
        'attributes'          => [
            'sitename' => 'DailySitter',
        ],
    ]);
};
