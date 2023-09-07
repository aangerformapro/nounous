<?php declare(strict_types=1);

use Carbon\Carbon;
use Models\AvailableAppointments;
use Models\Enfant;
use Models\User;

/* Enfant $enfant */

?>
<div class="container-facture" data-aos="fade-up">


    <div class="mb-3">
        <button type="button" class="btn btn-outline-info" id="facture-pdf">
            Imprimer en PDF
        </button>
    </div>
    <div id="facture">

        <div class="facture-heading d-flex justify-content-between mb-5">
            <div class="facture-logo" style="font-size: 48px;">
                <img src="/assets/pictures/logo/logox64.webp" alt="Logo" width="48" height="48" class="p-0">
                DailySitter
            </div>
            <div class="facture-address d-flex flex-column pt-5 col-5">

                <div class="name mb-2">
                    <?=$user; ?>
                </div>
                <div class="address">
                    <?=$user->getAddress(); ?>
                </div>

                <div class="city">
                    <?= $user->getZip() . ' ' . $user->getCity(); ?>
                </div>

            </div>
        </div>
        <div class="facture-body mt-5">

            <h4 class="mb-5">Facture pour <?= $enfant; ?></h4>

            <?php

            /**
             * @var User                  $nounou
             * @var AvailableAppointments $appointment
             */
            foreach ($rdvs as $nounou => $appointments):
                $tot             = 0;
                ?>

                <h5 class="text-capitalize mb-3">
                    Nourice: <?= $nounou; ?>
                </h5>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col" class="text-center">Début</th>
                        <th scope="col" class="text-center">Fin</th>
                        <th scope="col" class="text-center">Taux Horaire</th>
                        <th scope="col" class="text-center">Total</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($appointments as $appointment):
                        $totLine = Carbon::create($appointment->getEnd())
                            ->diffInHours($appointment->getStart(), true) * $appointment->getHourlyRate()
                        ;

                        $tot += $totLine;

                        ?>
                        <tr>
                            <td><?= $appointment->getDate()->format(FORMAT_DATE_DISPLAY); ?></td>
                            <td class="text-center"><?= $appointment->getStart()->format(FORMAT_TIME_DISPLAY); ?></td>
                            <td class="text-center"><?= $appointment->getEnd()->format(FORMAT_TIME_DISPLAY); ?></td>
                            <td class="text-center"><?= $appointment->getHourlyRate(); ?> €</td>
                            <td class="text-center"><?= $totLine; ?> €</td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4">&nbsp;</td>
                        <td class="text-center"><?= $tot; ?> €</td>
                    </tr>
                    </tbody>
                </table>

            <?php

            endforeach; ?>


        </div>

    </div>
</div>