<?php

use NGSOFT\Middlewares\CookieMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;

return function (App $app)
{
    $app->add(new BasePathMiddleware($app));

    $app->add(new CookieMiddleware());
};
