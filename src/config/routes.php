<?php

use Slim\App;
use Slim\Views\PhpRenderer;

return function (App $app)
{
    $app->get('/hello/{name}', function ($request, $response, $args)
    {
        $renderer = $this->get(PhpRenderer::class);
        return $renderer->render($response, 'index.php', $args);
    })->setName('profile');
};
