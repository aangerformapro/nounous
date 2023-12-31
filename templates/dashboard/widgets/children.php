<?php
$children           ??= [];
$postdata           ??= [];
$errors['children'] ??= [];

$childrenHasErrors = ! empty($errors['children']);
?>

<h3 class="text-capitalize mt-3" data-aos="fade-up">vos enfants</h3>
<div class="d-flex flex-column" data-aos="fade-up">
    <?php if( ! count($children)):?>
    <div class="mb-3 text-center">
        Vous n'avez pas d'enfants
    </div>

    <?php else:?>
        <div class="d-flex flex-wrap mb-3">
            <?php foreach ($children as $child):?>
                <div class="col-lg-4 p-1">
                    <div class="card child">
                        <div class="card-header d-flex">
                            <div class="prenom">
                                <?= $child->getPrenom(); ?>
                            </div>
                             <div class="ms-auto">(<?= $child->getAge(); ?> ans)</div>
                        </div>
                        <div class="card-body">
                            <a href="<?= urlFor('gardes', ['id_enfant' => $child->getId()]); ?>">Chercher une garde</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="text-center mb-3 add-child-widget <?= $childrenHasErrors ? 'd-none' : ''; ?>">
        <button class="btn custom-btn btn-a" id="add-child-toggle">
        <span>Ajouter</span><span>Ajouter</span>
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
                <input 
                type="date" 
                class="form-control <?= in_array('birthday', $errors['children']) ? 'is-invalid' : ''; ?>" 
                name="birthday" 
                id="birthday" 
                placeholder="Date de naissance" 
                max="<?= formatDateInput(date_create('now')); ?>"
                min="<?= date(FORMAT_DATE_INPUT, strtotime('-15 years')); ?>"
                required>
                <label for="prenom">Date de naissance</label>
                <div class="invalid-feedback">
                    Veuillez entrer une date valide
                </div>
        </div>

        <div class="form-submit-btn text-end p-3 d-none">
            <input type="hidden" name="user_id" value="<?= $user->getId(); ?>">
            <button type="submit" name="action" value="add_child" class="btn custom-btn btn-a">
            <span>Valider</span><span>Valider</span>
            </button>
        </div>
    </form>
   
</div>