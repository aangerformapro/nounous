<?php

use Monolog\Level;
use NGSOFT\Container\ContainerInterface;

use function Env\env;

return function (ContainerInterface $container)
{
    $container->set('Settings', [
        'displayErrorDetails' => true, // Should be set to false in production
        'logError'            => false,
        'logErrorDetails'     => false,
        'logger'              => [
            'name'  => 'app',
            'path'  => env('ROOT_DIR') . '/logs/app.log',
            'level' => Level::Debug,
        ],
    ]);
};
