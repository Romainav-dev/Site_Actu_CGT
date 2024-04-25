<?php
// Connexion à la base de données (à adapter selon votre configuration)
include('CGT_Connexion_DB.php');

// Vérifier si le formulaire a été soumis
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $user_id = $_POST['user_id']; // Assurez-vous que 'user_id' contient l'ID de l'utilisateur connecté
    $message = $_POST['message'];

    // Préparer la requête SQL pour insérer le message dans la table "messages"
    $requete = "INSERT INTO messages (message, user_id) VALUES (?, ?)";

    // Préparer la déclaration
    $stmt = $mysqli->prepare($requete);

    // Liaison des paramètres
    $stmt->bind_param("si", $message, $user_id);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Le message a été envoyé avec succès.";
    } else {
        echo "Erreur lors de l'envoi du message: " . $stmt->error;
    }

    // Fermer la déclaration
    $stmt->close();

    // Fermer la connexion à la base de données
    $mysqli->close();
}
?>
