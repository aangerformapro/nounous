<?php
$postdata ??= [];
?>

<div class="app page-login">
    <?php include 'components/nav.php'; ?>

    <div class="page d-flex justify-content-center align-items-center">
        <form method="post" action="<?= urlFor('register'); ?>" class="form-register">
            <h1 class="text-center mb-4 text-white">S'enregister</h1>
            <?php if(in_array('user', $errors)): ?>
                <div class="alert alert-danger" role="alert">
                    Une erreur est survenue lors de la création du compte utilisateur:
                    Email ou téléphone déjà enregistrés
                </div>
            <?php endif; ?>
            <div class="form-floating mb-3 px-lg-1">
                <input type="email" class="form-control <?= in_array('email', $errors) ? 'is-invalid' : ''; ?>" name="email" id="email" placeholder="Email" placeholder="Votre adresse Email" required>
                <label for="email">Votre adresse Email</label>
                <div class="invalid-feedback">
                    Veuillez entrer un email valide
                </div>

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
                    <input type="text" class="form-control <?= in_array('nom', $errors) ? 'is-invalid' : ''; ?>" name="nom" id="nom"  placeholder="Votre nom" required>
                    <label for="nom">Votre nom</label>
                </div>
                <div class="invalid-feedback">
                    Veuillez entrer un nom
                </div>

                <div class="form-floating mb-3 col-lg-6 px-lg-1">
                    <input type="text" class="form-control <?= in_array('prenom', $errors) ? 'is-invalid' : ''; ?>" name="prenom" id="prenom" placeholder="Votre prenom" required>
                    <label for="prenom">Votre prenom</label>
                    <div class="invalid-feedback">
                        Veuillez entrer un prénom
                    </div>
                </div>

            </div>

            <div class="form-floating mb-3 px-lg-1">
                <input type="text" class="form-control <?= in_array('address', $errors) ? 'is-invalid' : ''; ?>" name="address" id="address" placeholder="Votre adresse" required>
                <label for="address">Votre adresse</label>
                <div class="invalid-feedback">
                    Veuillez entrer une addresse
                </div>
            </div>
            <div class="d-flex flex-column flex-lg-row justify-content-lg-between ">

                <div class="form-floating mb-3 col-lg-4 px-lg-1">
                    <input type="text" class="form-control <?= in_array('zip', $errors) ? 'is-invalid' : ''; ?>" name="zip" id="zip"  placeholder="CP" maxlength="5" required>
                    <label for="zip">CP</label>
                    <div class="invalid-feedback">
                        Veuillez entrer un code postal valide
                    </div>
                </div>


                <div class="form-floating mb-3 col-lg-8 px-lg-1">
                    <input type="text" class="form-control <?= in_array('city', $errors) ? 'is-invalid' : ''; ?>" name="city" id="city"  placeholder="Ville" required>
                    <label for="city">Ville</label>
                    <div class="invalid-feedback">
                        Veuillez entrer une ville
                    </div>
                </div>
            </div>

            <div class="form-floating mb-3 px-lg-1">
                <input type="text" class="form-control <?= in_array('phone', $errors) ? 'is-invalid' : ''; ?>" name="phone" id="phone" placeholder="Votre téléphone" required>
                <label for="phone">Votre téléphone</label>
                <div class="invalid-feedback">
                    Veuillez entrer un téléphone valide
                </div>
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
                <input type="password" class="form-control <?= in_array('password', $errors) ? 'is-invalid' : ''; ?>" name="password" placeholder="Votre mot de passe" required>
                <label for="password">Votre mot de passe</label>
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
        

            <div class="text-center">
                <button type="submit" class="btn btn-danger">S'enregistrer</button>
            </div>

            <div class="">
                <a href="<?= urlFor('login'); ?>" title="Créer un compte" class="text-white">Se connecter</a>

            </div>
 
        </form>
    </div>

</div>


