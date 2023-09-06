<?php

declare(strict_types=1);

namespace Models;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

class FacturesParents extends Action
{
    protected function action(): Response
    {
        $mois = $annee = $id = null;

        $rdvs = [];

        if ($slug = $this->tryResolveArg('slug'))
        {
            $segments = explode('/', $slug);
            $annee    = $segments[0] ?? null;
            $mois     = $segments[1] ?? null;
            $id       = $segments[2] ?? null;
        }

        if (isset($annee))
        {
            $annee = (int) $annee;

            if ( ! is_numeric($mois) || ! in_range((int) $mois, 1, 12))
            {
                throw new HttpNotFoundException($this->request);
            }

            $mois  = (int) $mois;

            $rdvs  = AvailableAppointments::findForParents(
                $this->getUser(),
                'date LIKE ? AND status = "DONE" AND valid = 1',
                [
                    sprintf(
                        '%u-%s',
                        $annee,
                        $mois < 10 ? "0{$mois}" : "{$mois}"
                    ) . '%',
                ]
            );
        }

        return $this->render('factures', [
            'pagetitle' => 'Mes Factures',
            'mapMonth'  => [
                1  => 'Janvier',
                2  => 'Février',
                3  => 'Mars',
                4  => 'Avril',
                5  => 'Mai',
                6  => 'Juin',
                7  => 'Juillet',
                8  => 'Aout',
                9  => 'Septembre',
                10 => 'Octobre',
                11 => 'Novembre',
                12 => 'Décembre',
            ],
            'annee'     => $annee,
            'mois'      => $mois,
            'rdvs' => $rdvs,
        ]);
    }
}
