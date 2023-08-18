<div class="container-fluid fixed-top ">
    <a class="navbar-brand">
      <img src="/assets/pictures/logo/logox64.webp" alt="Logo" width="60" height="60" class="p-0">DailySitter</a>
</div>

<div class="page d-flex justify-content-center align-items-center">
<form method="post" action="/login" class="form-login">
<h1 class="p-3 text-white">Connexion</h1>
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
    <label class="form-check-label text-white" for="remember">Se souvenir de moi</label>
  </div>

  <div class="text-center">
     <button type="submit" class="btn bg-white">Se connecter</button>
  </div>

  <div class="link">
    <a href="/register" title="Créer un compte" class="text-white">Créer un compte</a><br>
    <a href="/login/recover" title="Mot de passe oublié?" class="text-white">Mot de passe oublié?</a>

  </div>
 
</form>
</div>
