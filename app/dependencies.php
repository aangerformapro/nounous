<?php

declare(strict_types=1);

use App\Application\Renderers\PhpRenderer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use NGSOFT\Container\ContainerInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Psr\Log\LoggerInterface;
use Roots\WPConfig\Config;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Interfaces\RouteParserInterface;

return function (ContainerInterface $container)
{
    $container->alias('view', PhpRenderer::class);

    $container->setMany([
        LoggerInterface::class      => function (PsrContainerInterface $c)
        {
            $settings       = $c->get('settings');
            $loggerSettings = $settings['logger'];
            $logger         = new Logger($loggerSettings['name']);

            $logger->pushProcessor(new UidProcessor());

            $handler        = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        PhpRenderer::class          => fn () => new PhpRenderer(
            Config::get('TEMPLATE_PATH'),
            'layout/layout',
            $container->get('settings')['attributes']
        ),

        \PDO::class                 => function ()
        {
            return new PDO(
                sprintf(
                    'mysql:host=%s;port=%s;dbname=%s;charset=%s',
                    Config::get('DB_HOST'),
                    Config::get('DB_PORT'),
                    Config::get('DB_NAME'),
                    Config::get('DB_CHARSET'),
                ),
                Config::get('DB_USER'),
                Config::get('DB_PASSWORD'),
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        },
        App::class                  => function (PsrContainerInterface $container)
        {
            AppFactory::setContainer($container);
            return AppFactory::create();
        },
        RouteParserInterface::class => function (PsrContainerInterface $container)
        {
            return $container->get(App::class)->getRouteCollector()->getRouteParser();
        },
    ]);
};
