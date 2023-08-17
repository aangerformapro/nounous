<?php

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use NGSOFT\Container\ContainerInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;
use Psr\Log\LoggerInterface;
use Views\PhpView;

return function (ContainerInterface $container)
{
    $view = new PhpView(TEMPLATE_PATH, [
        'sitetitle' => 'DailySitter',
    ]);

    $container->alias('view', PhpView::class);

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

        PhpView::class         => $view,

    ]);
};
