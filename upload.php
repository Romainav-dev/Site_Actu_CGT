<?php
// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){

    date_default_timezone_set('Europe/Paris');

    $titre = $_POST['name_titre'];
    $contenu = $_POST['name_description'];
    $lien = $_POST['lien'];
    $date_article = date("Y-m-d");
    $nom_categorie = $_POST['name_categorie'];

    $video_exist = $_POST['video_exist'];
    $image_exist = $_POST['image_exist'];

    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["video"]) && $_FILES["video"]["error"] == 0){
        $allowed = array("mp4" => "video/mp4");
        $filename = $_FILES["video"]["name"];
        $filetype = $_FILES["video"]["type"];
        $filesize = $_FILES["video"]["size"];

        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

        // Vérifie la taille du fichier - 1Go maximum
        $maxsize = 1000 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("VIDEO/" . $_FILES["video"]["name"])){
                echo $_FILES["video"]["name"] . " existe déjà.";
            } else{
                move_uploaded_file($_FILES["video"]["tmp_name"], "VIDEO/" . $_FILES["video"]["name"]);
                $video = $_FILES["video"]["name"];
            } 
        } else{
            echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
            $video = "";
        }
    } else{
        //echo "Error: " . $_FILES["video"]["error"];
        if($video_exist != ""){
            $video = $video_exist;
        } else{
            $video = "";
        }
    }

    // Vérifie si le fichier a été uploadé sans erreur.
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0){
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "png" => "image/png");
        $filename = $_FILES["image"]["name"];
        $filetype = $_FILES["image"]["type"];
        $filesize = $_FILES["image"]["size"];

        // Vérifie l'extension du fichier
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur : Veuillez sélectionner un format de fichier valide.");

        // Vérifie la taille du fichier - 1Go maximum
        $maxsize = 1000 * 1024 * 1024;
        if($filesize > $maxsize) die("Error: La taille du fichier est supérieure à la limite autorisée.");

        // Vérifie le type MIME du fichier
        if(in_array($filetype, $allowed)){
            // Vérifie si le fichier existe avant de le télécharger.
            if(file_exists("IMG/" . $_FILES["image"]["name"])){
                echo $_FILES["image"]["name"] . " existe déjà.";
            } else{
                move_uploaded_file($_FILES["image"]["tmp_name"], "IMG/" . $_FILES["image"]["name"]);
                $image = $_FILES["image"]["name"];
            } 
        } else{
            echo "Error: Il y a eu un problème de téléchargement de votre fichier. Veuillez réessayer.";
            $image = "";
        }
    } else{
        //echo "Error: " . $_FILES["image"]["error"];
        if($image_exist != ""){
            $image = $image_exist;
        } else{
            $image = "";
        }
    }

    include('CGT_Connexion_DB.php');

    if(isset($_POST['action'])) {
        if($_POST['action'] == 'add') {
            // Requête pour ajouter un nouvel article
            $requete = 'INSERT INTO articles (Titre, Contenu, Lien, Image, Video, DATE_Article, nom_categories) VALUES ("' . $titre . '", "' . $contenu . '", "' . $lien . '", "' . $image . '", "' . $video . '", "' . $date_article . '", "' . $nom_categorie . '")';
        } elseif($_POST['action'] == 'edit') {
            // Requête pour mettre à jour un article existant
            $requete = 'UPDATE articles SET Titre = "'. $titre .'", Contenu = "'. $contenu .'", Lien = "'. $lien .'", Image = "'. $image .'", Video = "'. $video .'", DATE_Article = "'. $date_article .'", nom_categories = "' . $nom_categorie . '"' . ' WHERE ID = ' . $_POST['article_id'];
        }
    }

    $resultat = $mysqli->query($requete);

    header('Location: get_articles.php');

    mysqli_close($mysqli);
}
?>