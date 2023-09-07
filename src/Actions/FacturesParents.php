<?php

declare(strict_types=1);

namespace Actions;

use App\Application\Actions\Action;
use Models\AvailableAppointments;
use Models\Enfant;
use NGSOFT\DataStructure\Map;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpNotFoundException;

class FacturesParents extends Action
{
    protected function initialize(): void
    {
        $this->phpRenderer->addAttributes([
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
            'user'      => $this->getUser(),
        ]);
    }

    protected function action(): Response
    {
        $mois   = $annee = $id = null;

        $rdvs   = [];

        if ($slug = $this->tryResolveArg('slug'))
        {
            $segments = explode('/', $slug);
            $annee    = $segments[0] ?? null;
            $mois     = $segments[1] ?? null;
            $id       = $segments[2] ?? null;
        }

        $result = new Map();

        if (isset($annee))
        {
            $annee   = (int) $annee;

            if (
                ! is_numeric($mois)
                || ! in_range((int) $mois, 1, 12)
                || ! is_numeric($id)
            ) {
                throw new HttpNotFoundException($this->request);
            }

            $mois    = (int) $mois;

            $id      = (int) $id;

            $rdvs    = AvailableAppointments::find(
                'id_enfant = ? AND date LIKE ? and status = "DONE" and valid = 1 ORDER BY date ASC',
                [
                    $id,
                    sprintf(
                        '%u-%s-',
                        $annee,
                        $mois < 10 ? "0{$mois}" : "{$mois}"
                    ) . '%',
                ]
            );

            $nounou  = null;
            $nid     = null;
            $entries = [];

            /** @var AvailableAppointments $rdv */
            foreach ($rdvs as $rdv)
            {
                if ($nid !== $rdv->getNounouId())
                {
                    $nid     = $rdv->getNounouId();
                    $nounou  = $rdv->getNounou();
                    $entries = [];
                }

                $entries[] = $rdv;
                $result->set($nounou, $entries);
            }
        }

        return $this->render('factures', [

            'annee'  => $annee,
            'mois'   => $mois,
            'rdvs'   => $result,
            'enfant' => isset($id) ? Enfant::findById($id) : null,
            'slug'   => $slug,
        ]);
    }
}
