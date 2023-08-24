
<div class="app page-login">
  <?php include 'components/nav.php'; ?>

  <div class="page d-flex justify-content-center align-items-center" data-aos="zoom-out">
    <form method="post" action="<?= urlFor('login'); ?>" class="form-login">
        <h1 class="p-3 text-white" data-aos="fade-right">Connection</h1>
        <?php if(in_array('login', $errors)): ?>
            <div class="alert alert-danger" role="alert">
                Vos identifiants sont incorrects
            </div>
        <?php endif; ?>

        <div class="form-floating mb-3" data-aos="fade-up">
          <input type="email" class="form-control <?= in_array('email', $errors) ? 'is-invalid' : ''; ?>" name="email" id="email" placeholder="Email" placeholder="Votre adresse Email" required>
          <label for="email">Votre adresse Email</label>
          <div class="invalid-feedback">
              Veuillez entrer un email valide
          </div>
        </div>
        <div class="form-floating mb-3" data-aos="fade-up">
            <input type="password" class="form-control <?= in_array('password', $errors) ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Votre mot de passe">
            <label for="password">Votre mot de passe</label>
            <div class="invalid-feedback">
              Veuillez entrer un mot de passe
          </div>
        </div>
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="remember">
        <label class="form-check-label text-white" for="remember">Se souvenir de moi</label>
      </div>

      <div class="text-center">
        <button type="submit" class="btn custom-btn btn-a text-white">Se connecter</button>
      </div>

      <div class="link">
        <a href="<?= urlFor('register'); ?>" title="Créer un compte" class="text-white">Créer un compte</a><br>
        <a href="/login/recover" title="Mot de passe oublié?" class="text-white">Mot de passe oublié?</a>

      </div>
    
    </form>
  </div>
</div>

