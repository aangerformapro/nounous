<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use NGSOFT\Facades\Container;
use Roots\WPConfig\Config;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Slim\ResponseEmitter;

use function Env\env;

require_once dirname(__DIR__) . '/vendor/autoload.php';

date_default_timezone_set('Europe/Paris');

// echo loadView('index', ['pagetitle' => 'Titre de la page', 'name' => $_GET['name'] ?? '']);

/**
 * Database Configuration .env.
 */
$rootDir              = dirname(__DIR__);

if (is_file($rootDir . '/.env'))
{
    $envFiles = ['.env'];

    if (is_file($rootDir . '/.env.local'))
    {
        $envFiles[] = '.env.local';
    }

    $dotEnv   = Dotenv::createUnsafeImmutable($rootDir, $envFiles, false);
    $dotEnv->load();

    if ( ! env('DATABASE_URL'))
    {
        $dotEnv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD']);
    }
}

Config::define('ROOT_DIR', $rootDir);
Config::define('DB_NAME', env('DB_NAME'));
Config::define('DB_USER', env('DB_USER'));
Config::define('DB_PASSWORD', env('DB_PASSWORD'));
Config::define('DB_HOST', env('DB_HOST') ?: 'localhost');
Config::define('DB_PORT', env('DB_PORT') ?: 3306);
Config::define('DB_CHARSET', 'utf8mb4');
Config::define('DB_COLLATE', 'utf8mb4_general_ci');
Config::apply();

/**
 * Container.
 */
$container            = Container::getFacadeRoot();

/**
 * Load Settings.
 */
$settings             = require_once __DIR__ . '/config/settings.php';

$settings($container);

/*
 * Container Definitions
 */

$definitions          = require_once __DIR__ . '/config/definitions.php';

$definitions($container);

/**
 * Database Connection.
 */
$database             = require_once __DIR__ . '/config/database.php';

$database($container);

/*
 * Initialize Application
 */

AppFactory::setContainer($container);

$app                  = AppFactory::create();
$callableResolver     = $app->getCallableResolver();

/**
 * Custom Middlewares.
 */
$middlewares          = require_once __DIR__ . '/config/middlewares.php';

$middlewares($app);

/**
 * Routes.
 */
$routes               = require_once __DIR__ . '/config/routes.php';

$routes($app);

$settings             = $container->get('Settings');

$displayErrorDetails  = $settings['displayErrorDetails'];
$logError             = $settings['logError'];
$logErrorDetails      = $settings['logErrorDetails'];

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request              = $serverRequestCreator->createServerRequestFromGlobals();

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
$errorMiddleware      = $app->addErrorMiddleware($displayErrorDetails, $logError, $logErrorDetails);

// Run App & Emit Response
$response             = $app->handle($request);
$responseEmitter      = new ResponseEmitter();
$responseEmitter->emit($response);
