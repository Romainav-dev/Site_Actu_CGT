<?php
require('verification_log.php');
login();

if (isset($_POST['valid_description'])) {
  include('CGT_Connexion_DB.php');

  $requete = 'UPDATE description_accueil SET Description = "' . $_POST['textarea_description'] . '";';
  $resultat = $mysqli->query($requete);

  mysqli_close($mysqli);
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <title>Site d'actualités</title>

  <style>
    body {
      font-family: "Helvetica Rounded", "Arial Rounded MT Bold", Arial, sans-serif;
    }

    .custom-navbar {
      background-color: #E31800;
      /* Remplace cette valeur par ta couleur personnalisée */
      /* Ajoute d'autres styles personnalisés si nécessaire */
    }

    #title {
      font-weight: bold;
    }

    .no-resize {
      resize: none;
      border: none;
      background-color: white;
    }

    .custom-button {
      background-color: #E31800;
      color: white;
      text-align: center;
    }
  </style>


  <script>
    function adjustTextareaHeight() {
      const textarea = document.getElementById('myTextarea');
      textarea.style.height = 'auto';
      textarea.style.height = textarea.scrollHeight + 'px';
    }

    window.addEventListener('DOMContentLoaded', adjustTextareaHeight);
  </script>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
    <a id="title" class="navbar-brand" href="index.php">La CGT Montjoie</a>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Accueil</a>
        </li>
        <?php
        if ($_SESSION['Acces'] == "1") {
          echo '<li class="nav-item">
          <a class="nav-link" href="get_articles.php">Administrateur</a>
        </li>';
        }
        ?>
        <?php
        if ($_SESSION['Acces'] != "1") {
          echo '<li class="nav-item">
          <a class="nav-link" href="get_articles.php">Articles</a>
        </li>';
          echo '<li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>';
        }
        ?>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Déconnexion</a>
        </li>
      </ul>
    </div>
  </nav>

  <form enctype="multipart/form-data" action="" method="post">

    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="text-center">Bonjour <?php echo $_SESSION['Prenom']; ?></h1>
        </div>
      </div>

      <div class="row align-items-center">
        <div class="col-md-6">
          <img alt="logo cgt" style="width: 100%;" class="img-fluid mx-auto d-block" src="images/logo_cgt.png" />
        </div>
        <div class="col-md-6">
          <p>
            Description de la CGT<br>
            Description de la CGT<br>
            Description de la CGT<br>
            Description de la CGT<br>
            Description de la CGT
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">
          <?php
          include('CGT_Connexion_DB.php');
          $requete = 'SELECT * FROM description_accueil;';
          $resultat = $mysqli->query($requete);
          $row = $resultat->fetch_assoc();
          $read = "readonly";
          $hidden = "hidden";
          $border = "";
          if ($_SESSION['Acces'] == "1") {
            $read = "";
            $hidden = "";
            $border = "border:1px solid black;";
          }
          echo '<textarea style="' . $border . ' overflow: hidden;" scrollbar id="myTextarea" name="textarea_description" class="form-control no-resize" ' . $read . ' rows="1"  oninput="adjustTextareaHeight()">' . $row['Description'] . '</textarea>';
          echo '<button ' . $hidden . ' name="valid_description" class="btn custom-button">Validé</button>';
          mysqli_close($mysqli);
          ?>
        </div>
      </div>
    </div>
  </form>
</body>

</html>