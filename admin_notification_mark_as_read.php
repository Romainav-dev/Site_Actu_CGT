<?php
// Connexion à la base de données (à adapter selon votre configuration)
include('CGT_Connexion_DB.php');

// Requête SQL pour marquer toutes les notifications comme lues
$requete = "UPDATE messages SET status = 'read'";

// Exécution de la requête
if ($mysqli->query($requete)) {
    // Réponse HTTP 200 OK pour indiquer que l'opération s'est déroulée avec succès
    http_response_code(200);
} else {
    // Réponse HTTP 500 Internal Server Error en cas d'erreur lors de l'exécution de la requête
    http_response_code(500);
}

// Fermer la connexion à la base de données
$mysqli->close();
?>
