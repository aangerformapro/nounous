<div class="d-flex flex-nowrap app dashboard ">
    <?php include 'dashboard/sidebar.php'; ?>

    <div class="main col">
        <?php
        include 'dashboard/widgets/profile.php';

    if ( ! isBabySitter())
    {
        include 'dashboard/widgets/children.php';
    }

    include 'dashboard/widgets/password.php';
    ?>
    </div>
</div>


