<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body class="b-home">



<!--  -->

<nav class="navbar navbar-expand-lg navbar-light ">
    <div class="container">
      <!-- Logo -->
        <div>
            <a class="navbar-brand">
            <img src="/assets/pictures/logo/logox64.webp" alt="Logo" width="60" height="60" class="p-0">DailySitter</a>
        </div>
      <!-- Bouton d'hamburger pour les petits écrans -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Liste de navigation -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-lg-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Accueil </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./login">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="./register">S'enregister</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <!-- Inclure le fichier JavaScript de Bootstrap (facultatif) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>