<nav class="navbar">
    <div class="navbar-container">
      <h2 class="navbar-brand" href="/">Site d'actualités</h2>
        <img src="./images/logo_cgt.png" style="width: 5%;" alt="logo CGT"/>
      <div class="navbar-collapse" id="navbar-collapse">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="./CGT/index.php">Accueil</a></li>
          <!-- <li class="nav-item"><a class="nav-link" href="./categorie_welcome.php">Catégories</a></li> -->
          <li class="nav-item"><a class="nav-link" href="./get_articles.php">Articles</a></li>
          <?php
          if($_SESSION['Prenom'] == "Joan"){
            echo '<li class="nav-item"><a class="nav-link" href="./get_articles.php">Administrateur</a></li>';
          }
          ?>
          <li class="nav-item"><a class="nav-link" name="deconnexion" href="./login.php">Déconnexion</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <?php

// Vérifier si l'utilisateur est déjà connecté
if(isset($_SESSION['Prenom']) && $_SESSION['Prenom'] === true && isset($_POST['deconnexion'])){
    // Détruire toutes les variables de session
    session_unset();
    
    // Détruire la session
    session_destroy();
    
    // Rediriger vers la page de connexion
    header("Location: login.php");
    exit;
}
?>