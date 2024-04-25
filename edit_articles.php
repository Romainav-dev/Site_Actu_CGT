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
  <link rel="stylesheet" href="styles.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <title>Modification d'un article</title>

</head>

<body>
<?php include("admin_Form.php"); ?>
  <div class="container">
    <h2>Modifier un article</h2>
    <form name="name_form" method="post" action="upload.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="edit">
    <input type="hidden" name="article_id" value="<?php echo $_GET['ID']; ?>">
      <?php
      include('CGT_Connexion_DB.php');
      $requete = 'SELECT * FROM categories 
      LEFT JOIN articles ON articles.nom_categories=categories.nom
      WHERE articles.ID like "' . $_GET['ID'] . '"';
      $resultat = $mysqli->query($requete);
      while ($row = $resultat->fetch_assoc()) {

        echo '<div class="form-group">';
        echo '<label for="name">Choisir une catégorie à associer à l\'article:</label>
        <select required name="name_categorie" class="form-control">
          <option></option>';
        // Récupération des articles depuis la base de données
        $query = 'SELECT * FROM categories';
        $result = $mysqli->query($query);
        while ($ligne = $result->fetch_assoc()) {
          if ($row['nom_categories'] == $ligne['nom']) {
            $val = "selected";
          } else {
            $val = "";
          }
          echo '<option ' . $val . ' value="' . $ligne['nom'] . '">' . $ligne['nom'] . '</option>';
        }
        echo '</select>
      </div>
      <div class="form-group">
        <label>Date</label>
        <input type="date" class="form-control" value="' . $row['DATE_Article'] . '"/>
      </div>
      <div class="form-group">
        <label for="name">Titre:</label>
        <input required type="text" id="id_titre" name="name_titre" class="form-control" value="' . $row['Titre'] . '" required>
      </div>
      <div class="form-group">
        <label for="name">Description :</label>
        <input type="text" placeholder="Description" id="id_description" name="name_description" class="form-control" value="' . $row['Contenu'] . '" required>
      </div>
      <div class="form-group">
        <label for="lien">Lien vers un site web :</label>
        <input type="text" id="lien" name="lien" class="form-control" value="' . $row['Lien'] . '">
      </div>
      <div class="form-group">
        <label for="image">Image :</label>
        <input type="file" id="id_image" name="image" class="form-control-file">';
        if (!empty($row['Image'])) {
          echo '<br>';
          echo 'Fichier actuel : <input style="width:auto;" type="text" name="image_exist" value="' . $row['Image'] .'">';
        }
        echo '</div>
      <div class="form-group">
        <label for="videos">Vidéo :</label>
        <input type="file" id="video" name="video" class="form-control-file">';
        if (!empty($row['Video'])) {
          echo '<br>';
          echo 'Fichier actuel : <input style="width:auto;" type="text" name="video_exist" value="' . $row['Video'] .'">';
        }
        echo '</div>';

        echo '<button type="submit" id="" name="btn_envoie" class="btn btn-primary">Modifier</button>';

        mysqli_close($mysqli);
      }
      ?>
    </form>
  </div>
</body>

</html>