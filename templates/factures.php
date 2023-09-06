<?php
declare(strict_types=1);
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
                    <div class="form-floating p-1 mb-3 col-lg-4">
                        <select class="form-select" name="year" id="year">
                            <?php for ($year = getCurrentYear(); $year >= getCurrentYear() - 2; --$year): ?>

                            <option value="<?= $year; ?>"
                                <?= ($annee ?? null) === $year ? 'selected' : ''; ?>
                            ><?= $year; ?></option>
                            <?php endfor; ?>
                        </select>
                        <label for="year">Année:</label>
                    </div>
                    <div class="form-floating p-1 mb-3 col-lg-4">
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
            <div class="form-submit-btn mb-3 d-flex  justify-content-end justify-content-lg-start col-lg p-2">
                <button
                        name="action"
                        value="facture_date"
                        type="submit"
                        class="btn btn-outline-primary">
                    Valider
                </button>

            </div>
        </form>

        <?php if(empty($rdvs)):?>
            <div data-aos="fade-up" class="alert alert-dark text-center">
                Vous n'avez pas de factures pour ce mois.
            </div>

        <?php endif; ?>
    </div>
</div>

