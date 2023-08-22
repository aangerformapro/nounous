<?php

declare(strict_types=1);

use Actions\EspaceUtilisateur;
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

        if ($data = $request->getAttribute('postdata'))
        {
            return $controller->connectUser($request, $response, $data);
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

    $app->map(['GET', 'POST'], '/register', function (ServerRequest $request, $response, $args)
    {
        if ($request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'home');
        }

        $controller = $this->get(RegisterActions::class);

        if ($data = $request->getAttribute('postdata'))
        {
            return $controller->createUser($request, $response, $data);
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

    $app->get('/espace-utilisateur', function (ServerRequest $request, Response $response)
    {
        if ( ! $request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'login');
        }

        $controller = $this->get(EspaceUtilisateur::class);

        return $controller->display($request, $response);
    })->setName('espace-utilisateur');

    $app->get('/', function ($request, $response, $args)
    {
        return $this->get('view')->render($response, 'home', $args);
    })->setName('home');
};
