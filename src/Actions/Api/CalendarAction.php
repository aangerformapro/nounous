<?php

declare(strict_types=1);

namespace Actions\Api;

use App\Application\Actions\Action;
use App\Application\Actions\ActionError;
use App\Application\Actions\ActionPayload;
use Models\AvailableAppointments;
use Models\UserType;
use Psr\Http\Message\ResponseInterface as Response;

class CalendarAction extends Action
{
    public function getBabysitterData(): array
    {
        $result = [];

        foreach (AvailableAppointments::find(
            'id_nounou = ? AND date >= ? AND id_enfant IS NOT NULL and status IN ("ACCEPTED")',
            [$this->getUser()->getId(), formatDateSQL(date_create('now'))]
        ) as $rdv){
            $day      = formatDateInput($rdv->getDate()) . 'T';
            $start    = $day . formatTimeInput($rdv->getStart());
            $end      = $day . formatTimeInput($rdv->getEnd());
            $result[] = [
                'start' => $start,
                'end'   => $end,
                'title' => $rdv->getEnfant()->getFullName(),
            ];
        }




        return $result;
    }

    public function getChildrenData(): array
    {
        $result = [];

        foreach ($this->getUser()->getChildren() as $child)
        {
            foreach (
                AvailableAppointments::find(
                    'id_enfant = ? AND status IN ("ACCEPTED") AND date >= ?',
                    [$child->getId(), formatDateSQL(date_create('now'))]
                ) as $rdv)
            {
                $day      = formatDateInput($rdv->getDate()) . 'T';
                $start    = $day . formatTimeInput($rdv->getStart());
                $end      = $day . formatTimeInput($rdv->getEnd());
                $result[] = [
                    'start' => $start,
                    'end'   => $end,
                    'title' => sprintf(
                        '%s chez %s',
                        $child->getPrenom(),
                        $rdv->getNounou()
                    ),
                ];
            }
        }

        return $result;
    }

    protected function action(): Response
    {
        if ($user = $this->getUser())
        {
            if (UserType::BABYSITTER === $user->getType())
            {
                $data = $this->getBabysitterData();
            } else
            {
                $data = $this->getChildrenData();
            }

            return $this->respondWithData($data);
        }

        return $this->respond(new ActionPayload(403, error: new ActionError('Not logged in.')));
    }
}
