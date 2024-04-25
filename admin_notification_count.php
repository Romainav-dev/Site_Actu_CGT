<?php
// Connexion à la base de données (à adapter selon votre configuration)
include('CGT_Connexion_DB.php');

// Requête SQL pour compter le nombre de nouvelles notifications non lues
$requete = "SELECT COUNT(*) AS notification_count FROM messages WHERE status = 'unread'";

// Exécution de la requête
$resultat = $mysqli->query($requete);

if ($resultat) {
    // Récupération du nombre de nouvelles notifications non lues
    $row = $resultat->fetch_assoc();
    $notification_count = $row['notification_count'];

    // Conversion du résultat en format JSON
    $response = array('notification_count' => $notification_count);
    echo json_encode($response);
} else {
    // En cas d'erreur, renvoyer une réponse avec un message d'erreur
    $response = array('error' => 'Erreur lors de la récupération du nombre de notifications');
    echo json_encode($response);
}

// Fermer la connexion à la base de données
$mysqli->close();
?>
