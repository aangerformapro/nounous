<?php

namespace Actions;

use Models\Enfant;
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

            'pagetitle' => 'Espace Utilisateur',
            'user'      => Container::get('user'),

            'children'  => Enfant::find('id_parent = ?', [
                $request->getAttribute('user')->getId(),
            ]),

        ]);
    }

    public function modifyUser(ServerRequest $request, Response $response, array $data)
    {
        $id = $data['user_id'];

        User::modifyUser($id, $data);

        return $this->redirectRenderer->redirectFor($response, 'espace-utilisateur');
    }

    public function modifyPassword(ServerRequest $request, Response $response, array $data)
    {
        $old    = $data['old_password'] ?? '';

        $errors = [];

        User::validateData($data, $validationErrors);

        if ( ! User::connectUser($request->getAttribute('user')->getEmail(), $old))
        {
            $errors[] = 'old_password';
        }

        foreach (['password', 'confirmpassword'] as $field)
        {
            if (in_array($field, $validationErrors))
            {
                $errors[] = $field;
            }
        }

        if ( ! count($errors))
        {
            User::modifyPassword($request->getAttribute('user'), $data['password']);

            return $this->redirectRenderer->redirectFor($response, 'espace-utilisateur');
        }

        return $this->phpRenderer->render($response, 'dashboard', [
            'pagetitle' => 'Espace Utilisateur',
            'user'      => Container::get('user'),
            'errors'    => $errors,
            'children'  => Enfant::find('id_parent = ?', [
                $request->getAttribute('user')->getId(),
            ]),
        ]);
    }

    public function addChild(ServerRequest $request, Response $response, array $data)
    {
        $data = Enfant::validateData($data, $errors);

        if (count($errors))
        {
            return $this->phpRenderer->render($response, 'dashboard', [
                'pagetitle' => 'Espace Utilisateur',
                'user'      => Container::get('user'),
                'errors'    => ['children' => $errors],
                'children'  => Enfant::find('id_parent = ?', [
                    $request->getAttribute('user')->getId(),
                ]),
            ]);
        }

        if (isset($data['birthday']))
        {
            $data['birthday'] = date_create_from_format(FORMAT_DATE_INPUT, $data['birthday']);
        }

        Enfant::generateChild($request->getAttribute('user'), $data);

        return $this->redirectRenderer->redirectFor($response, 'espace-utilisateur');
    }
}
