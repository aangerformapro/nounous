<?php declare(strict_types=1);
use Models\AvailableAppointments;
use Models\Status;

if( ! count($gardes))
{
    return;
}?>

<h3  class="text-capitalize" data-aos="fade-down">Vos Gardes</h3>
<?php
/** @var AvailableAppointments $item */
foreach ($gardes as $item): ?>

<form class="p-1" method="post" action="<?= urlFor('gardes'); ?>">
    <input type="hidden" name="id_appointment" value="<?= $item->getIdAppointment(); ?>">
    <div class="card">
        <div class="card-body">
            <div class="card-title d-flex">
                <h5>
                    <?= translateDate($item->getDate()); ?><br>
                    <small>de <?= formatTimeInput($item->getStart()); ?> à <?= formatTimeInput($item->getEnd()); ?></small>
                </h5>

            </div>
            <div class="card-text">

                <div class="mb-3 d-flex">
                    <div class="child-name">
                        <?= $item->getEnfant(); ?><br>
                        Chez <?= $item->getNounou(); ?>

                    </div>
                    <div class="ms-auto state">


                        <?php if(Status::PENDING === $item->getStatus()) : ?>
                            <div class="text-secondary">
                                En attente de validation
                            </div>
                        <?php else:?>
                            <div class="text-success">
                                Garde validée
                            </div>
                        <?php endif; ?>
                        <div class="text-end mt-3">
                            <button
                                    type="submit"
                                    name="action"
                                    value="set_cancel"
                                    class="btn btn-sm btn-outline-danger">
                                Annuler
                            </button>
                        </div>



                    </div>
                </div>

            </div>
        </div>
    </div>
</form>



<?php endforeach; ?>




