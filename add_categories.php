<?php
require('verification_log.php');
login();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- <link rel="stylesheet" href="styles.css"> -->

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <title>Ajout d'une catégorie</title>
</head>

<?php
if (isset($_POST['btn_creer']) && $_POST['name_categorie'] != "") {

  include('CGT_Connexion_DB.php');

  $numbering = 'SELECT MAX(ID) from categories';
  $max_ID_tmp = $mysqli->query($numbering);
  $max_ID = mysqli_fetch_row($max_ID_tmp);
  $max = intval($max_ID[0]) + 1;

  $categorie = $_POST['name_categorie'];

  //On prépare la commande sql d'insertion
  //Dans my.ini de mysql, supprimer le parametre NO_ZERO_DATE du mode strict
  $sql_1 = 'INSERT INTO categories VALUES ("' . $max . '", "' . $categorie . '")';

  $resultat = $mysqli->query($sql_1);

  // on ferme la connexion
  mysqli_close($mysqli);
}

if (isset($_POST['btn_supprimer']) && $_POST['name_categorie'] != "") {

  include('CGT_Connexion_DB.php');

  $requete = 'SELECT * FROM categories where nom like "' . $_POST['name_categorie'] . '"';
  $resultat = $mysqli->query($requete);
  $row = $resultat->fetch_assoc();

  $requete = 'DELETE FROM categories where ID like "' . $row['ID'] . '";';
  $resultat = $mysqli->query($requete);

  mysqli_close($mysqli);
}

?>

<body>
<?php include("admin_Form.php"); ?>
  <div class="container">
    <h2>Ajouter ou Supprimer une catégorie</h2>
    <form name="name_form" method="post" action="" enctype="multipart/form-data">
      <div class="form-group">
        <label for="name">Catégorie:</label>
        <input list="name_categorie" id="id_categorie" name="name_categorie" required class="form-control">
        <datalist id="name_categorie">
          <?php
          include('CGT_Connexion_DB.php');
          $requete = 'SELECT * FROM categories';
          $resultat = $mysqli->query($requete);
          while ($row = $resultat->fetch_assoc()) {
            echo '<option value ="' . $row['nom'] . '">' . $row['nom'] . '</option><br/>';
          }
          mysqli_close($mysqli);
          ?>
        </datalist>
      </div>
      <div class="form-group">
        <button type="submit" id="" name="btn_creer" class="btn btn-primary">Créer</button>
        <button type="submit" id="" name="btn_supprimer" class="btn btn-danger">Supprimer</button>
      </div>

      <div class="form-group">
        <br />
        <hr />
        <br />
      </div>

      <div class="form-group">
        <?php
        include('CGT_Connexion_DB.php');
        $requete = "SELECT * FROM categories";
        $resultat = $mysqli->query($requete);
        while ($row = $resultat->fetch_assoc()) {
          echo '<div>' . $row['nom'] . '</div>';
        }
        mysqli_close($mysqli);
        ?>
      </div>
    </form>
  </div>
</body>

</html>