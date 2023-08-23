<nav class="navbar d-lg-none">
    <button class="navbar-toggler" type="button" aria-label="Toggle navigation">
        <svg fill="currentColor" class="ng-svg-icon" width="32" height="32">
            <use xlink:href="#ng-menu"></use>
        </svg>
    </button>
</nav>


<div class="d-lg-flex flex-column flex-shrink-0 bg-body-cpink sidebar">
    <div class="mx-auto mt-3 text-end pe-3">
        <?php include 'components/logo.php'; ?>
    </div>
   
   <div class="p-5"></div>

    <ul class="nav flex-column mb-auto">
      <li class="nav-item">
        <a href="<?= urlFor('espace-utilisateur'); ?>" class="nav-link <?= isCurrentRoute('espace-utilisateur') ? 'active' : 'link-body-emphasis'; ?>" aria-current="page">
          Profil
        </a>
      </li>
      <li>
        <a href="<?= urlFor('calendar'); ?>" class="nav-link <?= isCurrentRoute('calendar') ? 'active' : 'link-body-emphasis'; ?>">
          Calendrier
        </a>
      </li>
      <li>
        <?php if(isBabySitter()):?>
            <a href="<?= urlFor('gardes'); ?>" class="nav-link <?= isCurrentRoute('gardes') ? 'active' : 'link-body-emphasis'; ?>">
                Gestion des gardes
            </a>
        <?php else:?>
            <a href="<?= urlFor('gardes'); ?>" class="nav-link <?= isCurrentRoute('gardes') ? 'active' : 'link-body-emphasis'; ?>">
                Reserver une garde
            </a>
        <?php endif; ?>
      </li>
      <li>
        <a href="<?= urlFor('factures'); ?>" class="nav-link <?= isCurrentRoute('factures') ? 'active' : 'link-body-emphasis'; ?>">
          Factures
        </a>
      </li>
    </ul>
  </div>