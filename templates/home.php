<div class="app page-home">
  <?php include 'components/nav.php'; ?>
  <div class="page container d-flex flex-nowrap flex-column flex-lg-row mx-auto">

      <div class="intro d-flex flex-column justify-content-center p-5 col-lg-6">
        <h2>Trouvez la meilleure garde d'enfant !</h2>
        <p class="d-none d-lg-flex">Garde périscolaire, baby-sitting ponctuel, assistante maternelle : nous sommes
           le meilleur site français de mise en relation parents / baby-sitters !</p>
        <div class="">
          <a href="<?= urlFor('espace-utilisateur'); ?>" class="btn custom-btn btn-a" >Commencer</a>
        </div>
      </div>
      <div class="home-img d-none d-lg-flex flex-column justify-content-center align-items-center">
        <img src="/assets/pictures/home-resized.webp" alt="home-img">
      </div>
  </div>
</div>

