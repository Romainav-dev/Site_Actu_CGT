<?php
// Récupère le mot de passe saisi par l'utilisateur
$password = $_POST['password'];

// Hache le mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_cgt";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifie la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Requête SQL pour insérer un utilisateur avec le mot de passe haché

$sql = 'INSERT INTO users VALUES ("", "", "", "", "'.$hashedPassword.'", "")';

if ($conn->query($sql) === TRUE) {
    echo "Utilisateur ajouté avec succès";
} else {
    echo "Erreur lors de l'ajout de l'utilisateur : " . $conn->error;
}

// Ferme la connexion à la base de données
$conn->close();


?>