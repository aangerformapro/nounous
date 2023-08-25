<nav class="navbar navbar-expand-lg">
    <div class="container">
     
    <?php include __DIR__ . '/logo.php'; ?>
      
      <!-- Bouton d'hamburger pour les petits écrans -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <svg fill="currentColor" class="ng-svg-icon" width="32" height="32">
          <use xlink:href="#ng-menu"></use>
        </svg>
      </button>
      
      <!-- Liste de navigation -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-lg-auto align-items-center">
          <li class="nav-item active">
            <a class="nav-link" href="<?= urlFor('home'); ?>">
            <svg fill="currentColor" class="ng-svg-icon" width="22" height="22">
                <use xlink:href="#ng-home"></use>
              </svg>
              Accueil
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= urlFor('contact'); ?>">
              <svg fill="currentColor" class="ng-svg-icon" width="22" height="22">
                <use xlink:href="#ng-contact"></use>
              </svg>
              Contact
            </a>
          </li> 
   
          <?php if( ! isLoggedIn()):?>
          <li class="nav-item">
            <a class="nav-link" href="<?= urlFor('login'); ?>">
              <svg fill="currentColor" class="ng-svg-icon" width="22" height="22">
                <use xlink:href="#ng-login"></use>
              </svg>
              Connexion
            </a>
          </li>
       
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= urlFor('espace-utilisateur'); ?>">
                <svg fill="currentColor" class="ng-svg-icon" width="22" height="22">
                  <use xlink:href="#ng-dashboard"></use>
                </svg>
                Espace
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= urlFor('logout'); ?>">
                <svg fill="currentColor" class="ng-svg-icon" width="22" height="22">
                  <use xlink:href="#ng-logout"></use>
                </svg>
                Déconnection
              </a>
            </li>
          <?php endif; ?>
         
        </ul>
      </div>
    </div>
  </nav>  