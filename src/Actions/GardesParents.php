<?php

declare(strict_types=1);

namespace Actions;

use Models\Appointment;
use Models\AvailableAppointments;
use Models\Enfant;
use Models\User;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class GardesParents extends BaseAction
{
    public function display(ServerRequest $request, Response $response, ?int $id = null): ResponseInterface
    {
        /** @var User $user */
        $user    = $request->getAttribute('user');

        $enfants = Enfant::find('id_parent = ?', [$user->getId()]);

        if (empty($enfants))
        {
            return $this->redirectRenderer->redirectFor($response, 'espace-utilisateur');
        }

        if ($postdata = $request->getAttribute('postdata'))
        {
            $action = $postdata['action'] ?? null;

            if ('add_appointment' === $action)
            {
                if (($id_appointment = $postdata['id_appointment']) && ($id_child = $postdata['id_child']))
                {
                    Appointment::updateEntry($id_appointment, [
                        'id_enfant' => $id_child,
                    ]);

                    return $this->redirectRenderer->redirectFor($response, 'gardes');
                }
            }
        }

        // get availabilities

        $slots   = AvailableAppointments::find(
            'status = "PENDING" AND date > NOW() AND id_enfant IS NULL ORDER BY date ASC'
        );

        $gardes  = [];

        return $this->phpRenderer->render($response, 'gardes', [
            'user'      => $request->getAttribute('user'),
            'enfants'   => $enfants,
            'parent'    => $user,
            'slots'     => $slots,
            'gardes'    => $gardes,
            'pagetitle' => 'Réserver une Garde',
        ]);
    }
}
