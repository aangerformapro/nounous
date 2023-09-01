<h3 class="text-capitalize" data-aos="fade-down">Votre profil</h3>


<div class="card widget w-100" data-aos="fade-up">
  <form method="post">
    <ul class="list-group list-group-flush">
      <li class="list-group-item d-flex p-0">
        <div class="form-floating col-6 p-1">
          <input 
            type="text" 
            id="nom" 
            value="<?= $user->getNom(); ?>"
            class="form-control" disabled>
            <label for="nom">
              Nom
            </label>
        </div>
        <div class="form-floating col-6 p-1">
          <input 
            type="text" 
            id="prenom" 
            value="<?= $user->getPrenom(); ?>"
            class="form-control" disabled>
            <label for="prenom">
              Prénom
            </label>
        </div>
      </li>
      <li class="list-group-item form-floating p-1">
        <button class="btn edit" title="Editer">
            <svg fill="currentColor" class="ng-svg-icon" width="32" height="32">
                <use xlink:href="#ng-edit"></use>
              </svg>
        </button>
        <input 
        type="text" 
        id="address" 
        name="address" 
        value="<?= $user->getAddress(); ?>"
        class="form-control" disabled>
        <label for="address">
          Votre Addresse
        </label>
      </li>
      <li class="list-group-item d-flex p-0">

        <div class="col-3 form-floating p-1">
          <input 
            type="text" 
            id="zip" 
            name="zip" 
            maxlength="5"
            value="<?= $user->getZip(); ?>"
            class="form-control" disabled>
            <label for="zip">
              Code Postal
            </label>
        </div>

        <div class="col-9 form-floating p-1">
          <button class="btn edit" title="Editer" data-fields="#city,#zip">
              <svg fill="currentColor" class="ng-svg-icon" width="32" height="32">
                  <use xlink:href="#ng-edit"></use>
                </svg>
          </button>
          <input 
            type="text" 
            id="city" 
            name="city" 

            value="<?= $user->getCity(); ?>"
            class="form-control" disabled>
            <label for="city">
              Ville
            </label>
        </div>
      </li>

      <li class="list-group-item form-floating p-1">
       
          <button class="btn edit" title="Editer">
              <svg fill="currentColor" class="ng-svg-icon" width="32" height="32">
                  <use xlink:href="#ng-edit"></use>
                </svg>
          </button>
          <input 
            type="text" 
            id="phone" 
            name="phone" 
            maxlength="10"
            value="<?= $user->getPhone(); ?>"
            class="form-control" disabled>
          <label for="phone">
            Téléphone
          </label>
      </li>
    </ul>

    <div class="form-submit-btn text-end p-3 d-none">
      <input type="hidden" name="user_id" value="<?= $user->getId(); ?>">

      <button type="submit" name="action" value="mod_user" class="btn custom-btn btn-a">
          <span>Valider</span><span>Valider</span>
      </button>
    </div>

    

  </form>
</div>
