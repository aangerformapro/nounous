<?php

declare(strict_types=1);

use Actions\RegisterActions;
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
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/')
            ;
        }

        if ('POST' === $request->getMethod())
        {
            $params = $request->getParams();
        }

        return $this->get('view')->render($response, 'login');
    });

    $app->map(['GET', 'POST'], '/login/recover', function ($request, $response)
    {
        if ($request->getAttribute('user'))
        {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/')
            ;
        }
        return $this->get('view')->render($response, 'login');
    })->setName('recover_password');

    $app->map(['GET', 'POST'], '/register', function ($request, $response, $args)
    {
        if ($request->getAttribute('user'))
        {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/')
            ;
        }

        $controller = $this->get(RegisterActions::class);

        if ('POST' === $request->getMethod())
        {
            return $controller->createUser($request, $response, $request->getParams());
        }

        return $controller->displayRegister($request, $response);
    })->setName('register');

    $app->get('/', function ($request, $response, $args)
    {
        return $this->get('view')->render($response, 'home', $args);
    })->setName('home');
};
