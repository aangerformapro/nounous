

<div class="page d-flex justify-content-center align-items-center">
<form method="post" action="/login" class="form-login">
    <div class="form-floating mb-3">
    <input type="email" class="form-control" name="email" placeholder="Email" placeholder="Votre adresse Email" required>
    <label for="floatingInput">Votre adresse Email</label>
    </div>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" name="password" placeholder="Votre mot de passe">
        <label for="password">Votre mot de passe</label>
    </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" name="remember">
    <label class="form-check-label" for="remember">Se souvenir de moi</label>
  </div>

  <div class="text-center">
     <button type="submit" class="btn btn-outline-danger">Se connecter</button>
  </div>

  <div class="">
    <a href="/register" title="Créer un compte">Créer un compte</a><br>
    <a href="/login/recover" title="Mot de passe oublié?">Mot de passe oublié?</a>

  </div>
 
</form>
</div>
