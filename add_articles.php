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

  <title>Ajout d'un article</title>
</head>

<body>
<?php include("admin_Form.php"); ?>
  <div class="container">
    <h2>Ajouter un article</h2>
    <form method="post" action="upload.php" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add">
      <div class="form-group">
        <label for="name">Choisir une catégorie à associer à l'article:</label>
        <select required name="name_categorie" class="form-control">
          <option></option>
          <?php
          include('CGT_Connexion_DB.php');

          // Récupération des articles depuis la base de données
          $query = "SELECT * FROM categories";
          $result = $mysqli->query($query);
          while ($row = $result->fetch_assoc()) {
            echo '<option>' . $row['nom'] . '</option>';
          }
          ?>
        </select>
      </div>
      <div class="form-group">
        <label>Date</label>
        <input type="date" class="form-control" />
      </div>
      <div class="form-group">
        <label for="name">Titre:</label>
        <input required type="text" id="id_titre" name="name_titre" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="name">Description :</label>
        <input type="text" placeholder="Description" id="id_description" name="name_description" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="lien">Lien vers un site web :</label>
        <input type="text" id="lien" name="lien" class="form-control">
      </div>
      <div class="form-group">
        <label for="image">Image :</label>
        <input type="file" name="image" id="fileUpload" class="form-control-file">
      </div>
      <div class="form-group">
        <label for="videos">Vidéo :</label>
        <input type="file" name="video" id="fileUpload" class="form-control-file">
      </div>

      <button type="submit" id="" name="btn_envoie" class="btn btn-primary">Envoyer</button>
    </form>
  </div>
</body>

</html>