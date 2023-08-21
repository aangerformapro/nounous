<?php

declare(strict_types=1);

use Actions\LoginActions;
use Actions\RegisterActions;
use App\Application\Renderers\RedirectRenderer;
use Models\Session;
use Slim\App;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

return function (App $app)
{
    // $app->group('/api', function () use ($app)
    // {
    //     // Library group
    //     $app->group('/library', function () use ($app)
    //     {
    //         // Get book with ID
    //         $app->get('/books/:id', function ($id)
    //         {
    //         });

    //         // Update book with ID
    //         $app->put('/books/:id', function ($id)
    //         {
    //         });

    //         // Delete book with ID
    //         $app->delete('/books/:id', function ($id)
    //         {
    //         });
    //     });
    // });

    $app->map(['GET', 'POST'], '/login', function (ServerRequest $request, Response $response)
    {
        if ($request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'home');
        }

        $controller = $this->get(LoginActions::class);

        if ('POST' === $request->getMethod())
        {
            return $controller->connectUser($request, $response, $request->getParams());
        }

        return $controller->display($request, $response);
    })->setName('login');

    // $app->map(['GET', 'POST'], '/login/recover', function ($request, $response)
    // {
    //     if ($request->getAttribute('user'))
    //     {
    //         return $this->get(RedirectRenderer::class)->redirectFor($response, 'home');
    //     }
    //     return $this->get('view')->render($response, 'login');
    // })->setName('recover_password');

    $app->map(['GET', 'POST'], '/register', function ($request, $response, $args)
    {
        if ($request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'home');
        }

        $controller = $this->get(RegisterActions::class);

        if ('POST' === $request->getMethod())
        {
            return $controller->createUser($request, $response, $request->getParams());
        }

        return $controller->display($request, $response);
    })->setName('register');

    $app->get('/logout', function ($request, $response)
    {
        $request->getAttribute('session')->removeItem('user');

        if ($session = $request->getAttribute('cookies')->readCookie('usersession'))
        {
            $request->getAttribute('cookies')->removeCookie('usersession');

            Session::removeSession($session);
        }

        return $this->get(RedirectRenderer::class)->redirectFor($response, 'home');
    })->setName('logout');

    $app->get('/contacts', function ($request, $response)
    {
        return $this->get('view')->render($response, 'contact');
    })->setName('contact');

    $app->get('/', function ($request, $response, $args)
    {
        return $this->get('view')->render($response, 'home', $args);
    })->setName('home');
};
