<nav class="navbar navbar-expand-lg flex-nowrap">
    <div class="container">
      <!-- Logo -->
      
          <a class="navbar-brand" href="<?= urlFor('home'); ?>">
            <img src="/assets/pictures/logo/logox64.webp" alt="Logo" width="60" height="60" class="p-0">
            DailySitter
          </a>
      
      <!-- Bouton d'hamburger pour les petits écrans -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Liste de navigation -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-lg-auto">
          <li class="nav-item active">
            <a class="nav-link" href="<?= urlFor('home'); ?>">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= urlFor('contact'); ?>">Contact</a>
          </li>
          <?php if( ! isLoggedIn()):?>
          <li class="nav-item">
            <a class="nav-link" href="<?= urlFor('login'); ?>">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= urlFor('register'); ?>">S'enregister</a>
          </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link" href="<?= urlFor('espace-utilisateur'); ?>">Votre Espace</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= urlFor('logout'); ?>">Se déconnecter</a>
            </li>
          <?php endif; ?>
         
        </ul>
      </div>
    </div>
  </nav>
  