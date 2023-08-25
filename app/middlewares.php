<?php

declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Facades\Settings;
use NGSOFT\Middlewares\CookieMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\ServerRequestCreatorFactory;

use function NGSOFT\Filesystem\require_file;

return function (App $app, ...$extra): ServerRequestInterface
{
    $container            = $app->getContainer();

    /**
     * Core middlewares.
     */
    $displayErrorDetails  = Settings::get('displayErrorDetails');
    $logError             = Settings::get('logError');
    $logErrorDetails      = Settings::get('logErrorDetails');

    $callableResolver     = $app->getCallableResolver();
    // Create Request object from globals
    $serverRequestCreator = ServerRequestCreatorFactory::create();
    $request              = $serverRequestCreator->createServerRequestFromGlobals();

    $responseFactory      = $app->getResponseFactory();
    $errorHandler         = new HttpErrorHandler($callableResolver, $responseFactory, $container->get(LoggerInterface::class));

    $shutdownHandler      = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
    register_shutdown_function($shutdownHandler);

    // Add Body Parsing Middleware
    $app->addBodyParsingMiddleware();

    // Add Routing Middleware
    $app->addRoutingMiddleware();

    foreach ($extra as $fn)
    {
        if (is_file($fn) && str_ends_with($fn, '.php'))
        {
            $fn = require_file($fn);
        }

        if (is_callable($fn))
        {
            $fn($app);
        }
    }

    $app->add(new CookieMiddleware());
    $app->add(new BasePathMiddleware($app));

    // Add Error Middleware
    $errorMiddleware      = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);
    $errorMiddleware->setDefaultErrorHandler($errorHandler);

    return $request;
};
