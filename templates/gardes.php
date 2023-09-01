<div class="d-flex flex-nowrap app dashboard ">
    <?php include 'dashboard/sidebar.php'; ?>

    <div class="main col">
        <?php include 'status-gardes.php'; ?>


        <h3 class="text-capitalize" data-aos="fade-up">Réserver une garde</h3>
        <?php if(empty($slots)) :?>
            <div data-aos="fade-up" class="alert alert-dark text-center">
                Il n'y a pas de gardes disponibles
            </div>
        <?php
            else:
                include 'gardes-disponibles.php';
            endif;
        ?>



        
    </div>
</div>

