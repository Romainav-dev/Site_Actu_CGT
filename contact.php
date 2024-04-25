<?php
require('verification_log.php');
login();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de Contact</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<?php
include("admin_Form.php");
?>

    <div class="container">
        <h2>Formulaire de Contact</h2>
        <form action="traitement_contact.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['ID']; ?>">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?php echo isset($_SESSION['Nom']) ? $_SESSION['Nom'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo isset($_SESSION['Prenom']) ? $_SESSION['Prenom'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['Email']) ? $_SESSION['Email'] : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </form>
    </div>
</body>
</html>
