<?php
declare(strict_types=1);

use Models\Enfant;

$annee ??= getCurrentYear();

if( ! isset($mois) && $annee === getCurrentYear())
{
    $mois = getCurrentMonth() - 1;

    if(0 === $mois)
    {
        $mois = 12;
        --$annee;
    }
}

?><div class="d-flex flex-nowrap app dashboard ">
    <?php include 'dashboard/sidebar.php'; ?>

    <div class="main col">

        <h3 class="text-capitalize" data-aos="fade-down">Mes Factures</h3>


        <form
                id="facture-select-date"
                action="<?= urlFor('factures'); ?>"
                method="post" class="d-lg-flex align-lg-items-center"
                data-aos="fade-up">
                    <div class="form-floating p-1 mb-3 col-lg-3">
                        <select class="form-select" name="year" id="year">
                            <?php for ($year = getCurrentYear(); $year >= getCurrentYear() - 2; --$year): ?>

                            <option value="<?= $year; ?>"
                                <?= ($annee ?? null) === $year ? 'selected' : ''; ?>
                            ><?= $year; ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="year">Année:</label>
                    </div>
                    <div class="form-floating p-1 mb-3 col-lg-3">
                        <select class="form-select" name="month" id="month">
                        <?php foreach (reversed($mapMonth) as $num => $str):?>
                            <option
                                    value="<?= $num; ?>"
                                    <?= $mois        === $num ? 'selected' : ''; ?>
                            >
                                <?=$str; ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <label for="month">
                            Mois:
                        </label>
                    </div>

            <?php if(!isBabySitter()):

                /** @var Enfant $child */
                $enfants = $user->getChildren();

                ?>
            <div class="form-floating p-1 mb-3 col-lg-3">

                <select name="enfant" id="enfant" class="form-select">
                    <?php foreach ($enfants as $child):?>
                        <option value="<?= $child->getId() ?>">
                            <?= $child?>
                        </option>
                    <?php endforeach;?>
                </select>
                <label for="enfant">
                    Enfant:
                </label>


            </div>
            <?php endif;?>
            <div class="form-submit-btn mb-3 d-flex  justify-content-end justify-content-lg-start p-2 col-lg">
                <button
                        name="action"
                        value="facture_date"
                        type="submit"
                        class="btn btn-outline-primary">
                    Valider
                </button>

            </div>
        </form>

        <?php if(!count($rdvs)):?>
            <div data-aos="fade-up" class="alert alert-dark text-center">
                Vous n'avez pas de factures pour ce mois.
            </div>
        <?php else:
            include isBabySitter() ? 'facture-nounou.php' : 'facture-parent.php';
            //dump($rdvs);
        endif; ?>
    </div>
</div>

