<?php

declare(strict_types=1);

use App\Application\ResponseEmitter\ResponseEmitter;
use NGSOFT\Facades\Container;
use Roots\WPConfig\Config;
use Slim\App;

use function NGSOFT\Filesystem\require_file_once;

/**
 * Load environment.
 */
require_once dirname(__DIR__) . '/app/env.php';

$app             = Container::get(App::class);

/*
 * Loads routes.
 */

if (is_callable($fn = require_file_once(__DIR__ . '/routes.php')))
{
    $fn($app);
}

/*
 * Loads middlewares.
 */

$request         = (require_once Config::get('APP_PATH') . '/middlewares.php')($app, __DIR__ . '/middlewares.php');

// Run App & Emit Response
$response        = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
