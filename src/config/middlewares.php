<?php

use Models\User;
use NGSOFT\Middlewares\CookieMiddleware;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;

return function (App $app)
{
    $app->add(function ($request, $next)
    {
        $session = $request->getAttribute('session');

        if ($session->hasItem('user'))
        {
            $request->setAttribute('user', new User($session->getItem('user')));
        }
        return $next->handle($request);
    });
    $app->add(new CookieMiddleware());
    $app->add(new BasePathMiddleware($app));
};
