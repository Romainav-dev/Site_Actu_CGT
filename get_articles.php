<?php
require('verification_log.php');
login();

// Vérifier si un article doit être supprimé
if(isset($_POST['article_id'])) {
  // Récupérer l'ID de l'article à supprimer
  $article_id = $_POST['article_id'];
  $control_supp = $_POST['control_supp'];

  // Connexion à la base de données
  include('CGT_Connexion_DB.php');

  // Préparer et exécuter la requête de suppression
  $requete = "DELETE FROM articles WHERE ID = ?";
  $stmt = $mysqli->prepare($requete);
  $stmt->bind_param("i", $article_id); // "i" pour integer
  $stmt->execute();

  if($stmt->affected_rows > 0 && $control_supp == 1) {
    echo '<div id="deleteMessage" style="display: block;">L\'article a été supprimé avec succès.</div>';
  } elseif($control_supp == 1 && $stmt->affected_rows == 0){
    echo '<div id="deleteMessage" style="display: block;">Erreur lors de la suppression de l\'article.</div>';
  }

  // Fermer la connexion à la base de données
  $stmt->close();
  $mysqli->close();
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Site d'actualités</title>
</head>

<script>
  function visible(index) {
    const commentBtn = document.getElementById("btn_comm_" + index);
    const commentInput = document.getElementById("comment__" + index);
    const envoieBtn = document.getElementById("envoie_" + index);
    const commentTextArea = document.getElementById("view_comment_" + index);
    commentBtn.style.display = "none";
    commentInput.style.display = "block";
    envoieBtn.style.display = "block";
    commentTextArea.style.display = "block";
  }

  function data_update(id_record) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      location.reload();
    }
    const url_a = "add_comment_action.php?ID=" + id_record +
      "&comment=" + document.getElementById("comment__" + id_record).value;

    xhttp.open("GET", url_a);
    xhttp.send();
  }

  function confirmDelete(articleId) {
    var res = confirm("Êtes-vous sûr de vouloir supprimer cet article ?");
    var i = 0;
    if (res) {
      i++;
      var inputElement = document.getElementById('deleteConfirmation');
      inputElement.setAttribute('value', articleId);
      var Supp = document.getElementById('controlSupp');
      Supp.setAttribute('value', i);
      document.getElementById('deleteForm').submit();
    }
  }
  setTimeout(function() {
        var deleteMessage = document.getElementById('deleteMessage');
        if (deleteMessage) {
            deleteMessage.style.display = 'none';
        }
    }, 3000);

  function Modifier(id_record) {
    ID = document.getElementById('id').innerHTML;
    window.open("edit_articles.php?ID=" + id_record);

  }

  // Fleche 

  // Afficher ou masquer la flèche en fonction du défilement
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("back-to-top").style.display = "block";
    } else {
        document.getElementById("back-to-top").style.display = "none";
    }
}

// Remonter en haut de la page lorsque la flèche est cliquée
document.getElementById("back-to-top").addEventListener("click", function(event) {
    event.preventDefault();
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
});

</script>

<body>

  <?php
  include("admin_Form.php"); 
  ?>

  <form id="deleteForm" enctype="multipart/form-data" action="" method="post">
    <input type="hidden" name="article_id" id="deleteConfirmation" value="">
    <input type="hidden" name="control_supp" id="controlSupp" value="0">

    <header>
      <h1 style="text-align:center;">Articles</h1>
    </header>

    <div class="container">
    <div class="row justify-content-center">
    <div class="col-md-4">
        <div class="mb-3">
            <div style="text-align:center;">
                <form method="post">
                    <select name="Categorie_Choice" class="form-control" style="width:90%;font-size:9pt;" onchange="this.form.submit()">
                        <option value="%"></option>
                        <?php
                        include('CGT_Connexion_DB.php');
                        $query = "SELECT * FROM categories";
                        $result = $mysqli->query($query);
                        while ($row = $result->fetch_assoc()) {
                            $sel = "";
                            if (isset($_POST['Categorie_Choice']) && $_POST['Categorie_Choice'] == $row['nom']) {
                                $sel = "selected";
                            }
                            echo '<option value="' . $row['nom'] . '" ' . $sel . '>' . $row['nom'] . '</option>';
                        }
                        mysqli_close($mysqli);
                        ?>
                    </select>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>


      <?php

      if (isset($_POST['Categorie_Choice']) == false) {
        $categorie_choice = "%";
      } else {
        $categorie_choice = $_POST['Categorie_Choice'];
      }

      $requete = 'SELECT * FROM categories
      LEFT JOIN articles ON articles.nom_categories=categories.nom
      WHERE articles.nom_categories like "' . $categorie_choice . '" ORDER BY articles.DATE_Article DESC, articles.ID DESC';

      include('CGT_Connexion_DB.php');
      $resultat = $mysqli->query($requete);
      $rowcount = mysqli_num_rows($resultat);

      echo '<br>';
      while ($ligne = $resultat->fetch_assoc()) {
        // Récupération des articles depuis la base de données
        echo '<div class="Non_Visible" id="id" name="name">' . $ligne['ID'] . '</div>';
        echo '<div class="articles">';
        if ($_SESSION['Acces'] == "1") {
          echo '<div class="div_icon_supp">';
          echo '<button type="button" class="btn btn-danger btn-sm mr-2" style="background-color: #E31800;" title="Supprimer" onclick="confirmDelete(' . $ligne['ID'] . ', 1)">Supprimer</button>';
          echo '<button type="button" class="btn btn-warning btn-sm" id="id_modifier" onclick="Modifier(' . $ligne['ID'] . ')" name="name_modifier" title="Modifier">Modifier</button>';
          echo '</div>';
        }
        echo '<p class="article-title">' . $ligne['Titre'] . '</p>';
        echo '<p class="article_description">' . $ligne['Contenu'] . '</p>';
        if ($ligne['Lien'] != "") {
          $lien = $ligne['Lien'];
          $lienAffiche = strlen($lien) > 100 ? substr($lien, 0, 100) . '...' : $lien;
          echo '<div>
                  <a href="' . $ligne['Lien'] . '" target="_blank">' . $lienAffiche . '</a>
                </div>';
        }
        if ($ligne['Image'] != "") {
          echo '<div>
                    <embed id="visu_img" src="/CGT/IMG/' . $ligne['Image'] . '" width="600px" height="auto" />
                </div>';
        }
        if ($ligne['Video'] != "") {
          echo '<div>
          <video width="420" height="340" controls><source src="VIDEO/' . $ligne['Video'] . '" type="video/mp4"></video>
          <input hidden type="text" id="video_name_id" name="video_name" value="' . $ligne['Video'] . '" />
          </div>';
        }
        echo '<div>';
        if ($ligne['Commentaires'] == "") {
          echo '<textarea readonly class="Non_Visible" id="view_comment_' . $ligne['ID'] . '" name="story" rows="1" cols="30" style="width: 100px;">' . $ligne['Commentaires'] . '</textarea>';
        } else {
          echo '<textarea readonly id="view_comment_' . $ligne['ID'] . '" name="story" rows="5" cols="30">' . $ligne['Commentaires'] . '</textarea>';
        }
        echo '</div>';
        echo '<div class="div_comment">';
        echo '<input type="text" id="comment__' . $ligne['ID'] . '" name="text_comment" class="class_com Non_Visible" placeholder="commentaire"/>
              </div>
              <br>';
        if ($_SESSION['Acces'] != "3") {
          echo '<div>';
          echo '<input type="button" id="btn_comm_' . $ligne['ID'] . '" class="" onclick="visible(' . $ligne['ID'] . ')" value="Commentaire"/> <input type="submit" class="Non_Visible" onclick="return data_update(' . $ligne['ID'] . ')" name="btn_envoyer" id="envoie_' . $ligne['ID'] . '" value="Envoyer"/>';
          echo '</div>';
        }
        echo '</div>';
        echo '<br>';
      }

      mysqli_close($mysqli);
      ?>
      </form>
      <a href="#" id="back-to-top" title="Retour en haut">&uarr;</a>
</body>

</html>