<?php

declare(strict_types=1);

namespace Actions;

use Models\AvailableAppointments;
use NGSOFT\DataStructure\Map;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

class FacturesNounous extends FacturesParents
{
    protected function action(): Response
    {
        $mois   = $annee = $id = null;

        $result = new Map();

        if ($slug = $this->tryResolveArg('slug'))
        {
            $segments = explode('/', $slug);
            $annee    = $segments[0] ?? null;
            $mois     = $segments[1] ?? null;
            $id       = $segments[2] ?? null;
        }

        if (isset($annee))
        {
            $annee    = (int) $annee;

            if ( ! is_numeric($mois) || ! in_range((int) $mois, 1, 12))
            {
                throw new HttpNotFoundException($this->request);
            }

            $mois     = (int) $mois;

            $rdvs     = AvailableAppointments::find(
                'id_nounou = ? AND date LIKE ? AND status = "DONE" AND valid = 1 ORDER BY id_enfant, date ASC',
                [
                    $this->getUser()->getId(),
                    sprintf(
                        '%u-%s',
                        $annee,
                        $mois < 10 ? "0{$mois}" : "{$mois}"
                    ) . '%',
                ]
            );

            $enfantId = null;
            $enfant   = null;

            $entries  = [];

            /** @var AvailableAppointments $rdv */
            foreach ($rdvs as $rdv)
            {
                if ($enfantId !== $rdv->getEnfantId())
                {
                    $entries  = [];
                    $enfant   = $rdv->getEnfant();
                    $enfantId = $rdv->getEnfantId();
                }
                $entries[] = $rdv;
                $result->set($enfant, $entries);
            }
        }

        return $this->render('factures', [

            'annee' => $annee,
            'mois'  => $mois,
            'rdvs'  => $result,
            'slug'  => $slug,
        ]);
    }
}
