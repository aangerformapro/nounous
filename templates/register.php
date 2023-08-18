<div class="container-fluid fixed-top ">
    <a class="navbar-brand">
      <img src="/assets/pictures/logo/logox64.webp" alt="Logo" width="60" height="60" class="p-0">DailySitter</a>
</div>

<div class="page d-flex justify-content-center align-items-center">
<form method="post" action="/login" class="form-register">
    <h1 class="text-center mb-4 text-white">S'enregister</h1>
    <div class="form-floating mb-3">
        <input type="email" class="form-control" name="email" placeholder="Email" placeholder="Votre adresse Email" required>
        <label for="floatingInput">Votre adresse Email</label>
    </div>
    <hr>
    <div class="d-flex align-items-center mb-3 text-white">
        <span class="me-3">Vous êtes :</span>
        <div class="me-3">
            <input type="radio" class="btn-check" name="type" id="type-parent" value="PARENT" autocomplete="off" checked>
            <label class="btn" for="type-parent">Un parent</label>
        </div>
        
        <div class="">
            <input type="radio" class="btn-check"  id="type-sitter" name="type" value="BABYSITTER" autocomplete="off">
            <label class="btn" for="type-sitter">Une nourice</label>
        </div>
    
    </div>

    <hr>
    <div class="d-flex flex-column flex-lg-row justify-content-lg-between">

        <div class="form-floating mb-3 col-lg-5">
            <input type="text" class="form-control" name="nom"  placeholder="Votre nom" required>
            <label for="floatingInput">Votre nom</label>
        </div>


        <div class="form-floating mb-3 col-lg-6">
            <input type="text" class="form-control" name="prenom"  placeholder="Votre prenom" required>
            <label for="floatingInput">Votre prenom</label>
        </div>

    </div>

    <div class="form-floating mb-3 me-lg-3 w-100">
        <input type="text" class="form-control" name="address"  placeholder="Votre adresse" required>
        <label for="floatingInput">Votre adresse</label>
    </div>
    <div class="d-flex flex-column flex-lg-row justify-content-lg-between">

        <div class="form-floating mb-3 me-lg-3 col-lg-4">
            <input type="number" class="form-control" name="zip"  placeholder="CP" maxlength="5" required>
            <label for="floatingInput">CP</label>
        </div>


        <div class="form-floating mb-3 col-lg-7">
            <input type="text" class="form-control" name="prenom"  placeholder="Ville" required>
            <label for="floatingInput">Ville</label>
        </div>
    </div>

    <div class="form-floating mb-3 me-lg-3 w-100">
        <input type="tel" class="form-control" name="phone"  placeholder="Votre téléphone" required>
        <label for="floatingInput">Votre téléphone</label>
    </div>

    <hr>
  
    <div class="d-flex align-items-center mb-3 text-white">
        <span class="me-3">Vous êtes :</span>
        <div class="me-3">
            <input type="radio" class="btn-check" name="gender" id="gender-female" value="FEMALE" autocomplete="off" checked>
            <label class="btn" for="gender-female">Une Femme</label>
        </div>
        
        <div class="">
            <input type="radio" class="btn-check"  id="gender-male" name="gender" value="MALE" autocomplete="off">
            <label class="btn" for="gender-male">Un Homme</label>
        </div>
    
    </div>

    <hr>
    <div class="form-floating mb-3">
        <input type="password" class="form-control" name="password" placeholder="Votre mot de passe">
        <label for="password">Votre mot de passe</label>
    </div>

    <div class="form-floating mb-3">
        <input type="password" class="form-control" name="confirmpassword" placeholder="Confirmer votre mot de passe">
        <label for="confirmpassword">Confirmer votre mot de passe</label>
    </div>
 

    <div class="text-center">
        <button type="submit" class="btn btn-danger">S'enregistrer</button>
    </div>

    <div class="">
        <a href="/login" title="Créer un compte" class="text-white">Se connecter</a>

    </div>
 
</form>
</div>
