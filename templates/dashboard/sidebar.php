<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
   <?php include 'layout/logo.php'; ?>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
      <li class="nav-item">
        <a href="<?= urlFor('espace-utilisateur'); ?>" class="nav-link active" aria-current="page">
          Profil
        </a>
      </li>
      <li>
        <a href="<?= urlFor('calendar'); ?>" class="nav-link link-body-emphasis">
          Calendrier
        </a>
      </li>
      <li>
        <?php if(isBabySitter()):?>
            <a href="<?= urlFor('gardes'); ?>" class="nav-link link-body-emphasis">
                Gestion des gardes
            </a>
        <?php else:?>
            <a href="<?= urlFor('gardes'); ?>" class="nav-link link-body-emphasis">
                Reserver une garde
            </a>
        <?php endif; ?>
      </li>
      <li>
        <a href="<?= urlFor('factures'); ?>" class="nav-link link-body-emphasis">
          Factures
        </a>
      </li>
    </ul>

   
  </div>