<?php

declare(strict_types=1);

namespace Actions;

use Models\Appointment;
use Models\Availability;
use Models\Status;
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
        $this->phpRenderer->addAttribute('idDispo', $id);

        $this->phpRenderer->addAttribute('slots', Appointment::find(
            'id_availability = ?',
            [$id]
        ));

        return $this->display($request, $response);
    }

    public function setGardeStatus(
        ServerRequest $request,
        Response $response,
        int|string $id,
        int|string $idDisp,
        bool $accepted
    ): ResponseInterface {
        Appointment::updateEntry($idDisp, [
            'status' => $accepted ? Status::ACCEPTED->value : Status::DECLINED->value,
        ]);

        return $this->redirectRenderer->redirectFor(
            $response,
            'mes-gardes',
            ['id' => $id]
        );
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
