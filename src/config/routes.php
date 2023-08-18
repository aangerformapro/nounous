<?php

use Slim\App;

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

    $app->any('/login', function ($request, $response)
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
    $app->any('/login/recover', function ($request, $response)
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
    $app->any('/register', function ($request, $response, $args)
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

        return $this->get('view')->render($response, 'register', $args);
    })->setName('register');

    $app->get('/', function ($request, $response, $args)
    {
        return $this->get('view')->render($response, 'home', $args);
    })->setName('home');
};
