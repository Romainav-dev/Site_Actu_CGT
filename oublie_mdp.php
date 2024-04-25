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


    <title>Changement de mot de passe</title>

    <script>
        function Verification() {
            mdp = document.getElementById('new_password').value;
            newMdp = document.getElementById('confirm_password').value;
            if (mdp == newMdp) {
                document.getElementById('submit').hidden = false;
            } else {
                document.getElementById('submit').hidden = true;
                mdp = "";
                newMdp = "";
            }
        }

        function onQuestionSelect() {
        // Récupérer la valeur sélectionnée dans le menu déroulant
        var selectedQuestion = document.getElementById("Question").value;

        // Tableau associatif des questions et de leurs IDs (c'est juste un exemple, vous devrez utiliser vos propres données)
        var questionIds = {
            "Quel est le nom de jeune fille de votre mère ?": 1,
            "Dans quelle ville êtes-vous né(e) ?": 2,
            "Quel est votre plat préféré ?": 3,
            "Quel était le nom de votre école primaire ?": 4,
            "Quel est le nom de votre animal de compagnie ?": 5
        };

        // Récupérer l'ID correspondant à la question sélectionnée
        var selectedQuestionId = questionIds[selectedQuestion];

        // Mettre à jour le champ de formulaire avec l'ID récupéré
        document.getElementById("id_question_select").value = selectedQuestionId;
        }
    </script>
    </script>

</head>

<?php
if (isset($_POST['btn_modif_mdp'])) {

    include('CGT_Connexion_DB.php');

    $email = $_POST['email'];
    $question_id = $_POST['id_question_select'];
    $response = $_POST['response'];

    $requete = 'SELECT * FROM users WHERE Email like "' . $email . '" AND secret_questions_id = "' . $question_id . '" AND responses = "'. $response .'";';
    $resultat = $mysqli->query($requete);
    $rowcount = mysqli_num_rows($resultat);

    if ($rowcount == "1") {
        $pastpassword = $_POST['password'];
        $new_mdp = $_POST['password_conf'];

        if ($pastpassword == $new_mdp) {

            $hashedPassword = password_hash($new_mdp, PASSWORD_DEFAULT);

            $requete = 'UPDATE users
                      SET
                        Password = "' . $hashedPassword . '"
                      WHERE Email like "' . $email . '";';

            $resultat = $mysqli->query($requete);
        }
        header('Location: login.php');
    }else{
        echo '<div style="color: red; font-weight: bold;">Les informations fournies sont incorrectes. Veuillez vérifier que votre e-mail, la question secrète ainsi que votre réponse sont correctes</div>';
    }

    // on ferme la connexions
    mysqli_close($mysqli);
}
?>

<body>
    <div class="login-container">
    <a href="login.php">Retour</a>
        <h1 style="text-align: center;">Mot de passe oublié</h1>
        <!-- zone de connexion -->
        <form action="" method="POST">

            <br>
            <div class="form-group">
                <label>Email<font color="red">*</font>:</label>
                <input type="email" placeholder="Entrer votre email" name="email" id="email">
            </div>

            <div class="form-group">
                        <label for="Question" class="form-label">Question secrète<font color="red">*</font>:</label>
                        <SELECT name="Questions_Choice" class="form-control" id="Question" type="submit" style="width:100%;font-size:9pt;" onchange="onQuestionSelect()" required>
                            <option value="%"></option>
                        <?php
                        include('CGT_Connexion_DB.php');
                        $query = "SELECT * FROM secret_questions;";
                        $result = $mysqli->query($query);
                        while ($row = $result->fetch_assoc()) {
                            $sel = "";
                            if (isset($_POST['Questions_Choice'])) {
                            if ($_POST['Questions_Choice'] == $row['questions']) {
                                $sel = "SELECTED";
                                $id_question_select = $row['id'];
                            } else {
                            }
                            }
                            if ($row['questions'] != "") {
                            echo '<OPTION value ="' . $row['questions'] . '"' . $sel . $id_question_select.'>' . $row['questions'] . '</option><br/>';
                        }
                        }
                        mysqli_close($mysqli);
                        ?>
                        </SELECT>
                    <div hidden>
                        <label for="id_question_select" class="form-label">Id de la question selectionné</label>
                        <input type="text" class="form-control" name="id_question_select" id="id_question_select" value="">
                    </div>
            </div>

            <div class="form-group">
                <label>Réponse<font color="red">*</font>:</label>
                <input type="text" placeholder="Entrer votre réponse" id="response_id" name="response" required>
            </div>

            <div class="form-group">
                <label>Nouveau mot de passe<font color="red">*</font>:</label>
                <input type="password" placeholder="Entrer le nouveau mot de passe" id="new_password" name="password" onblur="Verification()" required>
            </div>

            <div class="form-group">
                <label>Confirmation du nouveau mot de passe<font color="red">*</font>:</label>
                <input type="password" placeholder="Confirmer le nouveau mot de passe" id="confirm_password" name="password_conf" onblur="Verification()" required>
            </div>

            <input hidden type="submit" id='submit' name="btn_modif_mdp" value='Modifier' />
        </form>
    </div>
</body>

</html>