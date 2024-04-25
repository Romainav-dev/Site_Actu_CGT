<?php
require('verification_log.php');
login();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Messages - Administrateur</title>
    <!-- Inclure Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <?php include("admin_Form.php"); ?>
    <div class="container">
        <h2>Liste des Messages</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th hidden>ID</th>
                        <th>Message</th>
                        <th>User ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Connexion à la base de données (à adapter selon votre configuration)
                    include('CGT_Connexion_DB.php');

                    // Requête SQL pour récupérer tous les messages de la table "messages"
                    $requete = "SELECT id, message, user_id FROM messages ORDER BY id DESC";

                    // Exécution de la requête
                    $resultat = $mysqli->query($requete);

                    // Vérification s'il y a des messages
                    if ($resultat->num_rows > 0) {
                        // Affichage de chaque message
                        while ($row = $resultat->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td hidden>" . $row["id"] . "</td>";
                            echo "<td>" . $row["message"] . "</td>";
                            echo "<td>" . $row["user_id"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>Aucun message trouvé.</td></tr>";
                    }

                    // Fermer la connexion à la base de données
                    $mysqli->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
