<?php

declare(strict_types=1);

namespace Actions;

use Models\Appointment;
use Models\Enfant;
use Models\User;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class GardesParents extends BaseAction
{
    public function display(ServerRequest $request, Response $response): ResponseInterface
    {
        /** @var User $user */
        $user    = $request->getAttribute('user');

        $enfants = Enfant::find('id_parent = ?', [$user->getId()]);



        if (empty($enfants))
        {
            return $this->redirectRenderer->redirectFor($response, 'espace-utilisateur');
        }






        return $this->phpRenderer->render($response, 'gardes', [
            'user'      => $request->getAttribute('user'),
            'enfants'   => $enfants,
            'pagetitle' => 'Réserver une Garde',
        ]);
    }
}
