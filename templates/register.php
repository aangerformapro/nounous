<div class="app page-login">
    <?php include 'layout/nav.php'; ?>

    <div class="page d-flex justify-content-center align-items-center">
        <form method="post" action="/register" class="form-register">
            <h1 class="text-center mb-4">S'enregister</h1>
            <div class="form-floating mb-3 px-lg-1">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" placeholder="Votre adresse Email" required>
                <label for="email">Votre adresse Email</label>
            </div>
            <hr>
            <div class="d-flex align-items-center mb-3 text-white">
                <span class="me-3">Vous êtes :</span>
                <div class="me-3">
                    <input type="radio" class="btn-check" name="type" id="type-parent" value="PARENT" autocomplete="off" checked>
                    <label class="btn " for="type-parent">Un parent</label>
                </div>
                
                <div class="">
                    <input type="radio" class="btn-check"  id="type-sitter" name="type" value="BABYSITTER" autocomplete="off">
                    <label class="btn" for="type-sitter">Une nourice</label>
                </div>
            
            </div>

            <hr>
            <div class="d-flex flex-column flex-lg-row justify-content-lg-between">

                <div class="form-floating mb-3 col-lg-6 px-lg-1">
                    <input type="text" class="form-control" name="nom" id="nom"  placeholder="Votre nom" required>
                    <label for="nom">Votre nom</label>
                </div>


                <div class="form-floating mb-3 col-lg-6 px-lg-1">
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Votre prenom" required>
                    <label for="prenom">Votre prenom</label>
                </div>

            </div>

            <div class="form-floating mb-3 px-lg-1">
                <input type="text" class="form-control" name="address" id="address" placeholder="Votre adresse" required>
                <label for="address">Votre adresse</label>
            </div>
            <div class="d-flex flex-column flex-lg-row justify-content-lg-between ">

                <div class="form-floating mb-3 col-lg-4 px-lg-1">
                    <input type="text" class="form-control" name="zip" id="zip"  placeholder="CP" maxlength="5" required>
                    <label for="zip">CP</label>
                </div>


                <div class="form-floating mb-3 col-lg-8 px-lg-1">
                    <input type="text" class="form-control" name="city" id="city"  placeholder="Ville" required>
                    <label for="city">Ville</label>
                </div>
            </div>

            <div class="form-floating mb-3 px-lg-1">
                <input type="text" class="form-control" name="phone" id="phone" placeholder="Votre téléphone" required>
                <label for="phone">Votre téléphone</label>
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
            <div class="form-floating mb-3 px-lg-1">
                <input type="password" class="form-control" name="password" placeholder="Votre mot de passe" required>
                <label for="password">Votre mot de passe</label>
            </div>

            <div class="form-floating mb-3 px-lg-1">
                <input type="password" class="form-control" name="confirmpassword" placeholder="Confirmer votre mot de passe" required>
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

</div>


