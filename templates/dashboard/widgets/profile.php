<h3>Votre profil</h3>


<div class="card widget w-100">
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
        <?= $user->getNom() . ' ' . $user->getPrenom(); ?> 
    </li>
    <li class="list-group-item">
     <?= $user->getAddress(); ?> 
    </li>
    <li class="list-group-item">
        <?= $user->getZip(); ?>  <?= $user->getCity(); ?> 
    </li>

    <li class="list-group-item">
        <?= $user->getPhone(); ?> 
    </li>
  </ul>
</div>
