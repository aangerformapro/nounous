<div class="d-flex flex-nowrap app dashboard ">
    <?php use Models\Status;

    include 'dashboard/sidebar.php'; ?>

    <div class="main col">

        <h3 class="text-capitalize mb-3" data-aos="fade-down"><?= $pagetitle; ?></h3>

        <?php if(empty($listRdv)):?>
        <div data-aos="fade-up" class="alert alert-dark text-center">
            Vous n'avez pas de garde à valider.
        </div>


        <?php endif;?>

        <?php foreach ($listRdv as $item):
            $isParent               = $item['isParent'];
            ?>
        <form  data-aos="fade-up" class="p-1" method="post" action="<?= urlFor('validation-gardes'); ?>">

            <input type="hidden" name="id_rdv" value="<?= $item['rdv']->getId(); ?>">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <h5>
                            <?=  (new Carbon\Carbon($item['disp']->getDate()))->translatedFormat('D d M Y'); ?>
                            de <?= formatTimeInput($item['disp']->getStart()); ?> à <?= formatTimeInput($item['disp']->getEnd()); ?>
                        </h5>
                    </div>
                    <div class="card-text">
                        <div class="mb-3 d-flex">
                            <div class="child-name">
                                <?= $item['child']; ?>
                                <?php if($isParent)
                                {
                                    echo '<br>Chez ' . $item['disp']->getNounou();
                                }?>
                            </div>
                            <div class="ms-auto state">

                                <?php
                            $status = $item['rdv']->getStatus();

            if(Status::ACCEPTED === $status): ?>
                                <button
                                        type="submit"
                                        name="action"
                                        value="set_cancel"
                                        class="btn btn-sm btn-outline-danger">
                                    Annuler
                                </button>
                                <button
                                        type="submit"
                                        name="action"
                                        value="set_done"
                                        class="btn btn-sm btn-outline-success">
                                    Valider
                                </button>

                                <?php elseif (Status::CANCEL === $status): ?>
                                <div class="text-danger">
                                    Garde Annulée
                                </div>
                                <?php elseif (Status::DONE === $status && $isParent): ?>
                                    <button
                                            type="submit"
                                            name="action"
                                            value="set_valid"
                                            class="btn btn-sm btn-outline-success">
                                        Valider la garde
                                    </button>

                                <?php else:?>
                                    <div class="text-success">
                                        Garde Validée<br>
                                        <?php if(! $item['rdv']->getValid()): ?>
                                        <small class="text-secondary">En attente validation parent</small>

                                        <?php endif;?>
                                    </div>

                                <?php endif; ?>
                            </div>
                       
       
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <?php endforeach; ?>
    </div>
</div>