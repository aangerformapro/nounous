<?php

declare(strict_types=1);

use App\Application\Renderers\PhpRenderer;
use App\Facades\Settings;
use GuzzleHttp\Psr7\HttpFactory;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use NGSOFT\Container\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Log\LoggerInterface;
use Roots\WPConfig\Config;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Http\Factory\DecoratedResponseFactory;
use Slim\Interfaces\RouteParserInterface;

use function NGSOFT\Filesystem\require_all_once;

return function (Container $container)
{
    $container->alias('view', PhpRenderer::class);

    $container->setMany([

        LoggerInterface::class          => function ()
        {
            $logger  = new Logger(Settings::get('logger.name'));

            $logger->pushProcessor(new UidProcessor());

            $handler = new StreamHandler(Settings::get('logger.path'), Settings::get('logger.level'));
            $logger->pushHandler($handler);

            return $logger;
        },

        PhpRenderer::class              => fn () => new PhpRenderer(
            Settings::get('templates.path'),
            Settings::get('templates.layout', '')
        ),

        \PDO::class                     => function ()
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
        App::class                      => function (ContainerInterface $container)
        {
            AppFactory::setContainer($container);
            return AppFactory::create();
        },
        RouteParserInterface::class     => function (ContainerInterface $container)
        {
            return $container->get(App::class)->getRouteCollector()->getRouteParser();
        },

        ResponseFactoryInterface::class => function (ContainerInterface $container)
        {
            return new DecoratedResponseFactory(
                $container->get(HttpFactory::class),
                $container->get(HttpFactory::class),
            );
        },
    ]);

    foreach (require_all_once(__DIR__ . DIRECTORY_SEPARATOR . 'Dependencies') as $fn)
    {
        if (is_callable($fn))
        {
            $fn($container);
        }
    }
};
