<?php

namespace Actions;

use Models\User;
use NGSOFT\Facades\Container;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class EspaceUtilisateur extends BaseAction
{
    public function display(ServerRequest $request, Response $response): ResponseInterface
    {
        return $this->phpRenderer->render($response, 'dashboard', [
            'user' => Container::get('user'),

        ]);
    }

    public function modifyUser(ServerRequest $request, Response $response, array $data)
    {
        $id = $data['user_id'];

        User::modifyUser($id, $data);

        return $this->redirectRenderer->redirectFor($response, 'espace-utilisateur');
    }
}
