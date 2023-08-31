<?php

declare(strict_types=1);

namespace Actions;

use Models\Appointment;
use Models\Availability;
use Models\Enfant;
use Models\Status;
use Models\User;
use Models\UserType;
use Psr\Http\Message\ResponseInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest;

class ValidationGardes extends BaseAction
{
    public function display(ServerRequest $request, Response $response): ResponseInterface
    {
        /** @var User $user */
        $user = $request->getAttribute('user');

        if ($formdata = $request->getAttribute('postdata'))
        {
            $action = $formdata['action'] ?? '';

            if (
                ($id = $formdata['id_rdv'] ?? '') && $rdv = Appointment::findById($id)
            ) {
                if ('set_cancel' === $action)
                {
                    $rdv->setStatus(Status::CANCEL);
                    return $this->redirectRenderer->redirectFor($response, 'validation-gardes');
                }

                if ('set_done' === $action)
                {
                    $rdv->setStatus(Status::DONE);

                    if (UserType::PARENT === $user->getType())
                    {
                        $rdv->setValid(true);
                    }
                    return $this->redirectRenderer->redirectFor('validation-gardes');
                }

                if ('set_valid' === $action && UserType::PARENT === $user->getType())
                {
                    $rdv->setValid(true);
                    return $this->redirectRenderer->redirectFor('validation-gardes');
                }
            }
        }

        $data = [];

        if (UserType::BABYSITTER === $user->getType())
        {
            $avail = Availability::find(
                'date <= NOW() AND id_nounou = ? ORDER BY date DESC',
                [$user->getId()]
            );

            /** @var Availability $disp */
            foreach ($avail as $disp)
            {
                /** @var Appointment $rdv */
                foreach (Appointment::find(
                    'id_availability = ? AND status IN ( "ACCEPTED", "DONE", "CANCEL")',
                    [$disp->getId()]
                ) as $rdv)
                {
                    $data[] = [
                        'isParent' => false,
                        'rdv'      => $rdv,
                        'disp'     => $disp,
                        'child'    => $rdv->getEnfant(),
                    ];
                }
            }
        } else
        {
            $enfants = Enfant::find(
                'id_parent = ?',
                [$user->getId()]
            );

            /** @var Enfant $child */
            foreach ($enfants as $child)
            {
                /** @var Appointment $rdv */
                foreach (Appointment::find(
                    'id_enfant = ? AND status IN ( "ACCEPTED", "DONE") AND valid = 0',
                    [$child->getId()]
                ) as $rdv)
                {
                    if ($disp = Availability::findOne(
                        'id = ? AND date <= NOW()',
                        [$rdv->getIdAvailability()]
                    ))
                    {
                        $data[] = [
                            'isParent' => true,
                            'rdv'      => $rdv,
                            'disp'     => $disp,
                            'child'    => $child,

                        ];
                    }
                }
            }
        }
        return $this->phpRenderer->render($response, 'validation-gardes', [
            'pagetitle' => 'Validation des Gardes',
            'listRdv'   => $data,
        ]);
    }
}
