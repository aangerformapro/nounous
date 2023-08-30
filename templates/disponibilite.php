<div data-aos="fade-up" >
    <?php

use Models\Status;

    foreach ($slots as $disp) :?>

        <form class="p-1" method="post" action="<?= urlFor('mes-gardes' , ['id' => $idDispo])?>">
        <input type="hidden" name="id_disp" value="<?= $disp->getId();?>">
        <div class="card">
            <div class="card-body">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <h5>
                        <?=  (new Carbon\Carbon($item->getDate()))->translatedFormat('D d M,Y'); ?>
                    </h5>
                    <h6>
                     De <?= formatTimeInput($item->getStart()); ?> à <?= formatTimeInput($item->getEnd()); ?>
                    </h6>
                </div>
                
                <div class="card-text">

                    <div class="mb-3 d-flex">

                            <?php if($child = $disp->getEnfant() ) :?>
                                <div class="child-name">
                                    <?= $child; ?>
                                </div>

                                <div class="ms-auto state">

                                    <?php switch ($disp->getStatus())
                                    {
                                        case Status::PENDING:?>
                                        <button
                                                class="btn btn-sm btn-outline-danger"
                                                type="submit"
                                                name="action"
                                                value="set_declined">
                                            Refuser
                                        </button>
                                        <button
                                                class="btn btn-sm btn-outline-success"
                                                type="submit"
                                                name="action"
                                                 value="set_accepted">
                                            Accepter
                                        </button>

                                    <?php    break;
                                    case Status::ACCEPTED:?>
                                        <div class="text-success">
                                            Garde Acceptée
                                        </div>
                                        <?php
                                        break;

                                    case Status::DECLINED: ?>
                                        <div class="text-danger">
                                            Garde Refusée
                                        </div>
                                        <?php
                                        break;
                                    default:
                                        # code...
                                        break;
                                    } ?>
                                </div>


                            <?php else:?>
                                <div class="text-secondary">
                                    Pas de garde
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    <?php endforeach; ?>
</div>