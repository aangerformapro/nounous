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
        return $this->phpRenderer->render($response, 'mes-gardes', [
            'user'      => $request->getAttribute('user'),
            'pagetitle' => 'Gestion des Gardes',
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
