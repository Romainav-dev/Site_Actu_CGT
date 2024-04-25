<!doctype html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="styles.css" media="screen" type="text/css" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Login</title>
</head>

<body>
    <?php
    session_start();
    // Détruire toutes les variables de session
    session_unset();

    // Détruire la session
    session_destroy();

    ?>
    <div class="login-container">
    <a href="sign_up.php">S'inscrire</a>
        <h1 style="text-align:center;">Connexion</h1>
        <!-- zone de connexion -->
        <form action="verification_log.php" method="POST">

            <div class="form-group">
                <label>E-mail<font color="red">*</font>:</label>
                <input type="text" placeholder="Entrer votre e-mail" id="email_id" name="email" required>
            </div>

            <div class="form-group">
                <label>Mot de passe<font color="red">*</font>:</label>
                <input type="password" placeholder="Entrer le mot de passe" id="password_id" name="password" required>
            </div>

            <input type="submit" id='submit' value='Connexion' />
            <?php
            if (isset($_GET['erreur'])) {
                $err = $_GET['erreur'];
                if ($err == 1 || $err == 2)
                    echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
            }
            ?>
            <br>
            <br>
            <a href="oublie_mdp.php">Mot de passe oublié ?</a>
        </form>
    </div>
</body>

</html>