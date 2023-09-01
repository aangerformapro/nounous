<h3 class="text-capitalize mt-3" data-aos="fade-up">changer votre mot de passe</h3>


<form method="post" class="change-password" data-aos="fade-up">

    <div class="form-floating mb-3 px-lg-1">
        <input type="password" class="form-control <?= in_array('old_password', $errors) ? 'is-invalid' : ''; ?>" name="old_password" placeholder="Votre ancient mot de passe" required>
        <label for="old_password">Votre ancient mot de passe</label>
        <div class="invalid-feedback">
            Mot de passe incorrect
        </div>
    </div>
    <hr>
    <div class="form-floating mb-3 px-lg-1">
        <input type="password" class="form-control <?= in_array('password', $errors) ? 'is-invalid' : ''; ?>" name="password" placeholder="Votre nouveau mot de passe" required>
        <label for="password">Votre nouveau mot de passe</label>
        <div class="invalid-feedback">
            Votre mot de passe doit contenir un caractère spécial, une majuscule, une minuscule, un chiffre
            et doit faire au moins 8 caractères.
        </div>
    </div>

    <div class="form-floating mb-3 px-lg-1">
        <input type="password" class="form-control <?= in_array('confirmpassword', $errors) ? 'is-invalid' : ''; ?>" name="confirmpassword" placeholder="Confirmer votre mot de passe" required>
        <label for="confirmpassword">Confirmer votre mot de passe</label>

        <div class="invalid-feedback">
            Vous devez valider votre mot de passe
        </div>
    </div>

    <div class="form-submit-btn text-end p-3 d-none">
      <input type="hidden" name="user_id" value="<?= $user->getId(); ?>">

      <button type="submit" name="action" value="mod_pwd" class="btn btn custom-btn btn-a">
        <span>Valider</span><span>Valider</span>
      </button>
    </div>

</form>