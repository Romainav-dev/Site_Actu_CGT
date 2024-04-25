<?php
session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {


    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    if ($email != "" && $password != "") {
        // Récupère le mot de passe saisi dans le formulaire
        include('CGT_Connexion_DB.php');
        // Récupère le mot de passe haché depuis la base de données
        $requete = 'SELECT * FROM users WHERE Email like "' . $email . '";'; // Récupère le mot de passe haché correspondant à l'utilisateur depuis la base de données
        $result = $mysqli->query($requete);
        $row = $result->fetch_assoc();
        $dbPassword = $row['Password'];
        // Vérifie si le mot de passe saisi correspond au mot de passe haché en utilisant password_verify()
        if (password_verify($password, $dbPassword)) {
            // Mot de passe correct
            // Effectue les actions nécessaires (connexion réussie, redirection, etc.)
            header('Location: index.php');
            $_SESSION['ID'] = $row['ID'];
            $_SESSION['Nom'] = $row['Nom'];
            $_SESSION['Prenom'] = $row['Prenom'];
            $_SESSION['Email'] = $row['Email'];
            $_SESSION['Acces'] = $row['Acces'];
        } else {
            header('Location: login.php?erreur=1');
        }
        mysqli_close($mysqli);
    } else {
        header('Location: login.php?erreur=2');
    }
}


function login()
{
    if (!isset($_SESSION['Prenom']) || $_SESSION['Prenom'] == "") {
        header('Location: login.php');
        exit();
    }
} // fermer la connexion
