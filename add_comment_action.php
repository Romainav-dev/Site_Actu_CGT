<?php

session_start();

include('CGT_Connexion_DB.php');

$id = $_GET['ID'];

$v = $_SESSION['Prenom'] . " : " . htmlspecialchars($_GET['comment'], ENT_QUOTES);

$requete = 'SELECT Commentaires FROM articles WHERE ID = "' . $id . '";';
$resultat = $mysqli->query($requete);

while ($row = $resultat->fetch_assoc()) {
    if ($_GET['comment'] != "") {
        $v = $v . '\r\n' . $row['Commentaires'];
    } else {
        $v = $row['Commentaires'];
    }
}

$query = 'UPDATE articles SET Commentaires = "' . $v . '" WHERE ID = "' . $id . '";';
$result = $mysqli->query($query);

mysqli_close($mysqli);
