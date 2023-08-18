<?php

use Models\User;
use NGSOFT\Facades\Container;
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
            $request->setAttribute('user', $user = new User($session->getItem('user')));

            Container::set('user', $user);
        }
        return $next->handle($request);
    });
    $app->add(new CookieMiddleware());
    $app->add(new BasePathMiddleware($app));
};
