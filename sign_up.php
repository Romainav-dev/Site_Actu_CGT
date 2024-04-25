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

    <title>Inscription</title>
</head>

<body>
    <div class="login-container">
    <a href="login.php">Retour</a>
        <h1 style="text-align: center;">Inscription</h1>
        <!-- zone de connexion -->
        <form action="" method="POST">

            <div class="form-group">
                <label>Nom<font color="red">*</font>:</label>
                <input type="text" placeholder="Entrer votre nom" id="nom_id" name="nom" required>
            </div>

            <div class="form-group">
                <label>Prénom<font color="red">*</font>:</label>
                <input type="text" placeholder="Entrer votre prénom" id="prenom_id" name="prenom" required>
            </div>

            <div class="form-group">
                <label>E-mail<font color="red">*</font>:</label>
                <input type="text" placeholder="Entrer votre e-mail" id="email_id" name="email" required>
            </div>

            <div class="form-group">
                <label>Mot de passe<font color="red">*</font>:</label>
                <input type="password" placeholder="Entrer votre mot de passe" id="password_id" name="password" required>
            </div>

            <div class="form-group">
            <label for="question-select">Question secrète<font color="red">*</font>:</label>
            <?php
            echo '<SELECT name="Questions_Choice" class="form-control" type="submit" style="font-size:9pt;" required onchange="this.form.submit()">
					<option value="%"></option>';
            include('CGT_Connexion_DB.php');
            $query = "SELECT * FROM secret_questions;";
            $result = $mysqli->query($query);
            while ($row = $result->fetch_assoc()) {
                $sel = "";
                if (isset($_POST['Questions_Choice'])) {
                if ($_POST['Questions_Choice'] == $row['questions']) {
                    $sel = "SELECTED";
                } else {
                }
                }
                if ($row['questions'] != "") {
                echo '<OPTION value ="' . $row['id'] . '"' . $sel . '>' . $row['questions'] . '</option><br/>';
                }
            }
            mysqli_close($mysqli);

            echo '</SELECT>';
            ?>
            </div>

            <div class="form-group">
                <label>Réponse<font color="red">*</font>:</label>
                <input type="text" placeholder="Entrer votre réponse" id="response_id" name="response" required>
            </div>

            <input type="submit" id='submit' name="btn_inscription" value='Inscription' />
            <?php
            if(isset($_POST['btn_inscription'])){
                include('CGT_Connexion_DB.php');
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $question = $_POST['Questions_Choice'];
                $response = $_POST['response'];
                $acces = 2;
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $requete = 'INSERT INTO users (Nom, Prenom, Email, Password, Acces, secret_questions_id, responses) VALUES ("' . $nom . '","' . $prenom . '","' . $email . '","' . $hashedPassword . '","'. $acces .'","' . $question . '","' . $response . '");';
                $resultat = $mysqli->query($requete);
                mysqli_close($mysqli);
                if($resultat){
                    header('Location: login.php');
                }else{
                    echo '<script>alert("Erreur lors de l\'inscription")</script>';
                }
            }
            ?>
        </form>
    </div>
</body>

</html>