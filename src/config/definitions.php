<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use NGSOFT\Container\ContainerInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Psr\Log\LoggerInterface;
use Slim\Views\PhpRenderer;

return function (ContainerInterface $container)
{
    $container->setMany([
        LoggerInterface::class => function (PsrContainerInterface $c)
        {
            $settings       = $c->get('Settings');
            $loggerSettings = $settings['logger'];
            $logger         = new Logger($loggerSettings['name']);

            $logger->pushProcessor(new UidProcessor());

            $handler        = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);

            return $logger;
        },

        PhpRenderer::class     => new PhpRenderer(TEMPLATES),
    ]);
};
