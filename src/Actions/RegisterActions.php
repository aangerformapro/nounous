<?php

namespace Actions;

use Models\User;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class RegisterActions extends BaseAction
{
    public function display(ServerRequest $request, Response $response): ResponseInterface
    {
        return $this->phpRenderer->render($response, 'register', ['pagetitle' => 'Créer un compte']);
    }

    public function createUser(ServerRequest $request, Response $response, array $params): ResponseInterface
    {
        $data = User::validateData($params, $errors);

        if (empty($errors))
        {
            if ($user = User::createUser($data))
            {
                $request->getAttribute('session')->setItem('user', $user->getId());
                return $this->redirectRenderer->redirectFor($response, 'espace-utilisateur');
            }

            return $this->phpRenderer->render($response, 'register', [
                'errors'    => ['user'],
                'pagetitle' => 'Créer un compte',
            ]);
        }

        return $this->phpRenderer->render($response, 'register', [
            'errors'    => $errors,
            'postdata'  => $data,
            'pagetitle' => 'Créer un compte',
        ]);
    }
}
