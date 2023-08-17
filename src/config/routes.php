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
};
