<?php

use NGSOFT\Container\ContainerInterface;
use Roots\WPConfig\Config;

return function (ContainerInterface $container)
{
    $container->set(\PDO::class, function (): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            Config::get('DB_HOST'),
            Config::get('DB_PORT'),
            Config::get('DB_NAME'),
            Config::get(key: 'DB_CHARSET'),
        );

        return new PDO(
            sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                Config::get('DB_HOST'),
                Config::get('DB_PORT'),
                Config::get('DB_NAME'),
                Config::get(key: 'DB_CHARSET'),
            ),
            Config::get('DB_USER'),
            Config::get('DB_PASSWORD'),
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]
        );
    });
};