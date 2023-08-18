<?php

use Slim\App;

return function (App $app)
{
    $app->get('/hello/{name}', function ($request, $response, $args)
    {
        $renderer = $this->get('view');
        // $session  = $request->getAttribute('session');

        // var_dump($session);
        return $renderer->render($response, 'hello.php', $args);
    })->setName('hello');

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

    $app->post('/login', function ($request, $response, $args)
    {
        // var_dump($request->getParams());
        return $this->get('view')->render($response, 'login', $args);
    });

    $app->post('/register', function ($request, $response)
    {
        var_dump($request->getParams());
        return $this->get('view')->render($response, 'register', []);
    });

    $app->get('/login', function ($request, $response)
    {
        if ($user = $request->getAttribute('user'))
        {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/')
            ;
        }
        return $this->get('view')->render($response, 'login');
    });
    $app->get('/login/recover', function ($request, $response)
    {
        if ($user = $request->getAttribute('user'))
        {
            return $response
                ->withStatus(302)
                ->withHeader('Location', '/')
            ;
        }
        return $this->get('view')->render($response, 'login');
    });
    $app->get('/register', function ($request, $response, $args)
    {
        return $this->get('view')->render($response, 'register', $args);
    });

    $app->get('/', function ($request, $response, $args)
    {
        return $this->get('view')->render($response, 'home', $args);
    });
};
