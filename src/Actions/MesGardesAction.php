<?php

namespace Actions;

use Models\Availability;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class MesGardesAction extends BaseAction
{
    public function display(ServerRequest $request, Response $response): ResponseInterface
    {
        $nounou         = $request->getAttribute('user');

        $disponibilites = Availability::find('id_nounou = ? AND date > NOW()', [
            $nounou->getId(),
        ]);

        return $this->phpRenderer->render($response, 'mes-gardes', [
            'user'      => $nounou,
            'disp'      => $disponibilites,
            'pagetitle' => 'Gestion des Gardes',
        ]);
    }

    public function displayDisponibilite(ServerRequest $request, Response $response, int|string $id): ResponseInterface
    {
        return $this->phpRenderer->render($response, 'disponibilite', [
            'user'      => $request->getAttribute('user'),
            'idDispo'   => $id,
            'pagetitle' => 'Mes Rendez-vous',

        ]);
    }

    public function addAvailability(ServerRequest $request, Response $response, array $data): ResponseInterface
    {
        $nounou = $request->getAttribute('user');
        $slots  = (int) $data['slots'];
        unset($data['slots']);
        Availability::addAvailability($nounou, $data, $slots);
        return $this->getRedirectRenderer()->redirectFor($response, 'mes-gardes');
    }
}
