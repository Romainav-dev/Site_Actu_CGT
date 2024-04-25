<?php
include('CGT_Connexion_DB.php');

//$path_attachment = "VIDEO\\";

//$file_to_delete = $path_attachment . $_GET['video_nom'];          
//unlink($file_to_delete);

$requete = 'DELETE FROM articles where ID like "' . $_GET['ID'] . '";';
$resultat = $mysqli->query($requete);

mysqli_close($mysqli);
