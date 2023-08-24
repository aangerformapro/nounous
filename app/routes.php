<?php

declare(strict_types=1);

use Actions\EspaceUtilisateur;
use Actions\LoginActions;
use Actions\RegisterActions;
use App\Application\Renderers\RedirectRenderer;
use Models\Session;
use Models\User;
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

    $app->map(['GET', 'POST'], '/espace-utilisateur', function (ServerRequest $request, Response $response)
    {
        if ( ! $request->getAttribute('user'))
        {
            return $this->get(RedirectRenderer::class)->redirectFor($response, 'login');
        }

        $controller = $this->get(EspaceUtilisateur::class);

        if ($data = $request->getAttribute('postdata'))
        {
            $action = $data['action'] ?? '';

            if ('mod_user' === $action)
            {
                return $controller->modifyUser($request, $response, $data);
            }

            if ('mod_pwd' === $action)
            {
                return $controller->modifyPassword($request, $response, $data);
            }

            if ('add_child' === $action)
            {
                return $controller->addChild($request, $response, $data);
            }
        }
        return $controller->display($request, $response);
    })->setName('espace-utilisateur');

    $app->get('/espace-utilisateur/factures', function (ServerRequest $request, Response $response)
    {
        return $this->get('view')->render($response, 'factures');
    })->setName('factures');

    $app->get('/espace-utilisateur/calendar', function (ServerRequest $request, Response $response)
    {
        return $this->get('view')->render($response, 'calendar');
    })->setName('calendar');

    $app->get('/espace-utilisateur/gardes', function (ServerRequest $request, Response $response)
    {
        return $this->get('view')->render($response, 'gardes');
    })->setName('gardes');

    $app->get('/', function ($request, $response, $args)
    {
        return $this->get('view')->render($response, 'home', $args);
    })->setName('home');
};
