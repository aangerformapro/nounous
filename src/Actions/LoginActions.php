<?php

namespace Actions;

use Models\User;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class LoginActions extends BaseAction
{
    public function display(ServerRequest $request, Response $response): ResponseInterface
    {
        return $this->phpRenderer->render($response, 'login', ['pagetitle' => 'Connection']);
    }

    public function connectUser(ServerRequest $request, Response $response, array $params): ResponseInterface
    {
        $errors = [];

        if ( ! filter_var($params['email'] ?? '', FILTER_VALIDATE_EMAIL))
        {
            $errors[] = 'email';
        }

        if (empty($params['password']))
        {
            $errors[] = 'password';
        }

        if ( ! count($errors))
        {
            $user = User::connectUser($params['email'], $params['password']);

            if ( ! $user)
            {
                $errors[] = 'login';
            } else
            {
                if (isset($params['remember']))
                {
                    // create session
                }

                $request->getAttribute('session')->setItem('user', $user->getId());
                return $this->redirectRenderer->redirectFor($response, 'home');
            }
        }

        return $this->phpRenderer->render($response, 'login', [
            'pagetitle' => 'Connection',
            'errors'    => $errors,
        ]);
    }
}
