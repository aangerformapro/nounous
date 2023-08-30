<div class="d-flex flex-nowrap app dashboard ">
    <?php

use Carbon\Carbon;

    include 'dashboard/sidebar.php'; ?>

    <div class="main col">
        <h3 class="text-capitalize" data-aos="fade-down">Vos Disponibilités</h3>


        <form method="post" action="<?= urlFor('mes-gardes'); ?>"   data-aos="fade-up">

        <div class="d-lg-flex flex-lg-nowrap mb-3">
            <div class="form-floating  col-lg-8 p-1">
                <select class="form-select" aria-label="Nombre d'enfants" name="slots" id="slots" required>
                    <option value="1">1 Enfant</option>
                    <option value="2">2 Enfants</option>
                    <option value="3">3 Enfants</option>
                    <option value="4">4 Enfants</option>
                    <option value="5">5 Enfants</option>
            
                </select>
                <label for="">Nombre d'enfants</label>

            </div>

            <div class="form-floating  col-lg-4 p-1">

                    <input 
                        type="number" 
                        id="hourly_rate" 
                        name="hourly_rate" 
                        max="5.76"
                        min="3.57"
                        value="3.57"
                        step="0.01"
                        class="form-control" required>
                    <label for="hourly_rate">Taux Horaire</label>
            </div>
        </div>

            <div class="d-lg-flex flex-lg-nowrap mb-3">
                <div class="form-floating col-lg-4 p-1">
                    <input 
                        type="date" 
                        id="date" 
                        name="date" 
                        min="<?= formatDateInput(date_create('now')); ?>"
                        class="form-control" required>
                    <label for="date">Jour</label>
                </div>
                <div class="form-floating col-lg-4 p-1">
                    <input 
                        type="time" 
                        id="start" 
                        name="start" 
                        min="5:00"
                        max="21:00"
                        class="form-control" required>
                    <label for="date">Début</label>
                </div>

                <div class="form-floating col-lg-4 p-1">
                    <input 
                        type="time" 
                        id="end" 
                        name="end" 
                        max="21:00"
                        min="5:00"
                        class="form-control" required>
                    <label for="date">Fin</label>
                </div>
            </div>
        


            <div class="form-submit-btn text-end p-3 d-none">
                <button type="submit" name="action" value="add_availability" class="btn custom-btn btn-a">
                    Valider
                </button>
            </div>
        </form>



        <div class="my-availabilities d-lg-flex flex-lg-nowrap"  data-aos="fade-up">
            <?php foreach ($disp as $item):?>

                <div class="col-lg-4 p-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex">
                                <h5 class="col-10">
                                    <?=  (new Carbon($item->getDate()))->translatedFormat('D d M,Y'); ?>

                                </h5>
                                <div class="badge rounded-pill text-bg-secondary ms-auto fs-5"><?= count($item); ?></div>
                            </div>
                           
                            <p class="card-text">
                                De <?= formatTimeInput($item->getStart()); ?> à <?= formatTimeInput($item->getEnd()); ?>
                            </p>
                            <a href="<?= urlFor('mes-gardes', ['id' => $item->getId()]); ?>" class="card-link">Voir Rendez-vous</a>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

          


        </div>

     

        <?php if(isset($slots))
        {
            include 'disponibilite.php';
        } ?>
        
    </div>

</div>

