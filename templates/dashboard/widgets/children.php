<?php
$children           ??= [];
$postdata           ??= [];
$errors['children'] ??= [];

$childrenHasErrors = ! empty($errors['children']);
?>

<h3 class="text-capitalize mt-3">vos enfants</h3>
<div class="d-flex flex-column">
    <?php if( ! count($children)):?>
    <div class="mb-3 text-center">
        Vous n'avez pas d'enfants
    </div>

    <?php else:?>
        <div class="mb-3 mb-3">
            <?php foreach ($children as $child):?>
                <div class="child">
                    <?= $child->getPrenom(); ?> <?= $child->getNom(); ?> 
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="text-center mb-3 add-child-widget <?= $childrenHasErrors ? 'd-none' : ''; ?>">
        <button class="btn custom-btn btn-a" id="add-child-toggle">
            Ajouter
        </button>
    </div>

    <form method="post" id="add-child-form" class=" <?= ! $childrenHasErrors ? 'd-none' : ''; ?>">
        <div class="d-flex flex-column flex-lg-row justify-content-lg-between">

            <div class="form-floating mb-3 col-lg-6 px-lg-1">
                <input type="text" class="form-control <?= in_array('nom', $errors['children']) ? 'is-invalid' : ''; ?>" name="nom" id="nom"  placeholder="Nom Enfant" value="<?= $postdata['nom'] ?? $user->getNom(); ?>" required>
                <label for="nom">Nom Enfant</label>
            </div>
            <div class="invalid-feedback">
                Veuillez entrer un nom
            </div>

            <div class="form-floating mb-3 col-lg-6 px-lg-1">
                <input type="text" class="form-control <?= in_array('prenom', $errors['children']) ? 'is-invalid' : ''; ?>" name="prenom" id="prenom" placeholder="Prénom Enfant" required>
                <label for="prenom">Prénom Enfant</label>
                <div class="invalid-feedback">
                    Veuillez entrer un prénom
                </div>
            </div>
            </div>

            <div class="form-floating mb-3 p-1">
                <input type="date" class="form-control <?= in_array('birthday', $errors['children']) ? 'is-invalid' : ''; ?>" name="birthday" id="birthday" placeholder="Date de naissance" required>
                <label for="prenom">Date de naissance</label>
                <div class="invalid-feedback">
                    Veuillez entrer une date valide
                </div>
        </div>

        <div class="form-submit-btn text-end p-3 d-none">
            <input type="hidden" name="user_id" value="<?= $user->getId(); ?>">
            <button type="submit" name="action" value="add_child" class="btn custom-btn btn-a">
                Valider
            </button>
        </div>
    </form>
   
</div>