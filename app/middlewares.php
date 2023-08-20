<?php

declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use NGSOFT\Middlewares\CookieMiddleware;
use Psr\Log\LoggerInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\Http\ServerRequest;

return function (App $app): ServerRequest
{
    $container            = $app->getContainer();
    $settings             = $container->get('settings');

    /*
     * Put other middlewares there.
     */

    $app->add(new CookieMiddleware());
    $app->add(new BasePathMiddleware($app));

    /**
     * Core middlewares.
     */
    $displayErrorDetails  = $settings['displayErrorDetails'];
    $logError             = $settings['logError'];
    $logErrorDetails      = $settings['logErrorDetails'];

    $callableResolver     = $app->getCallableResolver();
    // Create Request object from globals
    $serverRequestCreator = ServerRequestCreatorFactory::create();
    $request              = $serverRequestCreator->createServerRequestFromGlobals();

    $responseFactory      = $app->getResponseFactory();
    $errorHandler         = new HttpErrorHandler($callableResolver, $responseFactory, $container->get(LoggerInterface::class));

    $shutdownHandler      = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
    register_shutdown_function($shutdownHandler);

    // Add Routing Middleware
    $app->addRoutingMiddleware();

    // Add Body Parsing Middleware
    $app->addBodyParsingMiddleware();

    // Add Error Middleware
    $errorMiddleware      = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);

    return $request;
};
