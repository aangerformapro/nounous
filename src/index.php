<?php

declare(strict_types=1);

use App\Application\ResponseEmitter\ResponseEmitter;
use NGSOFT\Facades\Container;
use Roots\WPConfig\Config;
use Slim\App;

/**
 * Load environment.
 */
require_once dirname(__DIR__) . '/app/env.php';

$app             = Container::get(App::class);

/**
 * Loads routes.
 */
(require_once Config::get('APP_PATH') . '/routes.php')($app);

/**
 * Loads middlewares.
 */
$request         = (require_once Config::get('APP_PATH') . '/middlewares.php')($app);

// Run App & Emit Response
$response        = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);
