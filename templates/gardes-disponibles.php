<div data-aos="fade-up" class="gardes-disponibles">
    <?php
    /** @var \Models\AvailableAppointments $item */

    use Models\Enfant;

    foreach ($slots as $item): ?>

    <form class="p-1" method="post" action="<?= urlFor('gardes'); ?>">
        <input type="hidden" name="id_appointment" value="<?= $item->getIdAppointment(); ?>">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex">
                    <h5>
                        <?= translateDate($item->getDate()); ?><br>
                        <small>de <?= formatTimeInput($item->getStart()); ?> à <?= formatTimeInput($item->getEnd()); ?></small>
                    </h5>

                    <div class="nom-nounou ms-auto">
                        Chez <?= $item->getNounou(); ?>
                    </div>
                </div>
                <div class="card-text">
                    <div class="text-center">
                        <button
                            type="button"
                            class="btn btn-outline-success select-appointment">
                            Réserver
                        </button>
                    </div>
                    <div class="mb-3 d-flex justify-content-center align-items-center form-select-child d-none">
                        <div class="p-1 col-4">
                            <div class="form-floating">
                                <select  class="form-select"  name="id_child">
                                    <option disabled selected>Sélectionner votre enfant</option>
                                    <?php
                                    /** @var Enfant $child */
                                    foreach ($enfants as $child):?>
                                    <option value="<?= $child->getId(); ?>">
                                        <?= $child->getPrenom(); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <label for="id_child">Choisir un enfant</label>
                            </div>
                        </div>
                        <div class="col-4 p-1">
                            <button
                                type="submit"
                                name="action"
                                value="add_appointment"
                                class="btn btn-outline-success btn-lg" disabled>
                                Réserver
                            </button>
                        </div>




                    </div>

                </div>
            </div>
        </div>

    </form>





    <?php endforeach; ?>

</div>