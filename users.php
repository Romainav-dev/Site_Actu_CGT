<?php
session_start();
?>

<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <title>Utilisateurs</title>

    <script>
        // RECUPERATION DES VALEURS CHOISIES PAR L'UTILISATEUR POUR MODIFICATION/SUPPRESSION
        function frame_update(obj) {
            document.getElementById("ID").value = obj.cells[1].textContent.trim();
            document.getElementById("Nom").value = obj.cells[2].textContent.trim();
            document.getElementById("Prenom").value = obj.cells[3].textContent.trim();
            document.getElementById("email").value = obj.cells[4].textContent.trim();
            document.getElementById("password").value = obj.cells[5].textContent.trim();
            document.getElementById("Acces").value = obj.cells[6].textContent.trim();

            //document.getElementById("Question").value = obj.cells[7].textContent.trim();
            const questionId = obj.cells[7].textContent.trim();
            const questionDropdown = document.getElementById("Question");

            for (let i = 0; i < questionDropdown.options.length; i++) {
                if (questionDropdown.options[i].value === questionId) {
                    questionDropdown.selectedIndex = i;
                    document.getElementById("id_question_select").value = questionDropdown.selectedIndex;
                    break;
                }
            }

            document.getElementById("Response").value = obj.cells[8].textContent.trim();


            // SELECTION DU BOUTON RADIO ASSOCIE A LA LIGNE DU TABLEAU CHOISI
            const indx = "Radio_Picked_User_" + obj.cells[1].textContent.trim();
            document.querySelector('input[name="Picked_User"]:checked');
            document.getElementById(indx).checked = true;

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
</head>

<!----------------------------->
<!-- SUPPRESSION UTILISATEUR -->
<!----------------------------->
<?php


// Vérifie si une question a été sélectionnée
if (isset($_POST['Questions_Choice'])) {
    // Connexion à la base de données
    include('CGT_Connexion_DB.php');

    // Préparation de la requête SQL pour récupérer l'ID de la question sélectionnée
    $selectedQuestion = $_POST['Questions_Choice'];
    $query = "SELECT id FROM secret_questions WHERE questions = ?";
    
    // Utilisation d'une requête préparée pour éviter les injections SQL
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $selectedQuestion);
    $stmt->execute();
    
    // Récupération du résultat
    $stmt->bind_result($questionId);
    $stmt->fetch();
    
    // Fermeture du statement
    $stmt->close();
    
    // Fermeture de la connexion à la base de données
    $mysqli->close();
}

$msg_conf = "";

if (isset($_POST['Delete_user'])) {
    //Préparation des inputs de l'utilisateur
    $id = $_POST['ID'];
    $Prenom = $_POST['Prenom'];

    //Connexion à la Base
    include('CGT_Connexion_DB.php');

    //Préparation de la requete SQL
    $requete = 'DELETE FROM users WHERE ID = "' . $id . '";';

    // Query execution
    $resultat = $mysqli->query($requete);
    mysqli_close($mysqli);

    // Message confirmation
    $msg_conf = '</br> Utilisateur ' . $Prenom . ' supprimé.</br>';
}

// <!-------------------------->
// <!-- CREATION UTILISATEUR -->
// <!-------------------------->

if (isset($_POST['Create_user']) && (isset($_POST['Nom'])) && (($_POST['Nom']) != "") && (isset($_POST['Prenom']))  && (($_POST['Prenom']) != "")  && (isset($_POST['email']))  && (($_POST['email']) != "")  && (($_POST['ID']) == "")) {

    //On récupère les valeurs entrées par l'utilisateur :
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $email = $_POST['email'];
    $Mdp = $_POST['password'];
    $Acces = $_POST['Acces'];
    $Question = $_POST['id_question_select'];
    $Response = $_POST['Response'];

    // Hache le mot de passe
    $hashedPassword = password_hash($Mdp, PASSWORD_DEFAULT);

    //Connexion à BD
    include('CGT_Connexion_DB.php');

    //On prépare la commande sql d'insertion
    //Dans my.ini de mysql, supprimer le parametre NO_ZERO_DATE du mode strict
    $requete = 'INSERT INTO users VALUES ("", "' . $Nom . '", "' . $Prenom . '", "' . $email . '", "' . $hashedPassword . '", "' . $Acces . '", "'. $Question .'", "'. $Response .'")';
    $resultat = $mysqli->query($requete);

    // on ferme la connexion
    mysqli_close($mysqli);

    // Message confirmation
    $msg_conf = '</br> Nouvel utilisateur ' . $Prenom . ' créé!</br>';
}

// <!------------------------>
// <!-- UPDATE UTILISATEUR -->
// <!------------------------>

if (isset($_POST['Update_user']) && isset($_POST['Nom']) && ($_POST['Nom']) != "" && isset($_POST['Prenom']) && ($_POST['Prenom']) != "" && (isset($_POST['email']))  && ($_POST['email']) != "" && (($_POST['ID']) != "")) {


    //Connexion à BD
    include('CGT_Connexion_DB.php');

    //On récupère les valeurs entrées par l'utilisateur :
    // Get user input values and prepare them for SQL query
    $ID = $_POST['ID'];
    $Prenom = $_POST['Prenom'];
    $Nom = $_POST['Nom'];
    $email = $_POST['email'];
    $Acces = $_POST['Acces'];
    $Question = $_POST['id_question_select'];
    $Response = $_POST['Response'];

    $Mdp = $_POST['password'];

    $requete = 'SELECT Password FROM users where ID like "' . $_POST['ID'] . '"';
    $resultat = $mysqli->query($requete);
    $row = $resultat->fetch_assoc();

    $dbPassword = $row['Password'];

    if ($Mdp == $dbPassword) {
        $Mdp = $dbPassword;
    } else {
        $hashedPassword = password_hash($Mdp, PASSWORD_DEFAULT);
        $Mdp = $hashedPassword;
    }

    $requete = 'UPDATE users
			  SET 
				Nom = "' . $Nom . '",
				Prenom = "' . $Prenom . '",
				Email = "' . $email . '",
                Password = "' . $Mdp . '",
				Acces = "' . $Acces . '",
                secret_questions_id = "' . $Question . '",
                responses = "' . $Response . '"
			  WHERE ID like "' . $ID . '";';

    $resultat = $mysqli->query($requete);

    // on ferme la connexion
    mysqli_close($mysqli);

    // Message confirmation
    $msg_conf = '</br> Utilisateur ' . $Prenom . ' mis à jour !</br>';
}
?>


<body>
<?php include("admin_Form.php"); ?>
    <form method="post" action="" enctype="multipart/form-data">

        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <h4>Gestion Utilisateurs</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <p class="lead">Remplissez les champs pour créer un nouvel utilisateur ou mettez à jour les informations de l'utilisateur sélectionné :</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <input type="hidden" name="ID" id="ID">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="Nom" class="form-label">Nom<font color="red">*</font>:</label>
                        <input type="text" class="form-control" name="Nom" id="Nom" placeholder="Nom" title="Nom de famille">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="Prenom" class="form-label">Prénom<font color="red">*</font>:</label>
                        <input type="text" class="form-control" name="Prenom" id="Prenom" placeholder="Prénom" title="Prénom">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email<font color="red">*</font>:</label>
                        <input type="email" class="form-control" name="email" id="email" title="Adresse email complète - Obligatoire" placeholder="mdupont@scmlemans.com">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe<font color="red">*</font>:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Entrer le mot de passe">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="Acces" class="form-label">Accès<font color="red">*</font>:</label>
                        <input type="text" class="form-control" name="Acces" id="Acces" title="Accès des utilisateurs sur le site">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="Question" class="form-label">Question<font color="red">*</font>:</label>
                        <SELECT name="Questions_Choice" class="form-control" id="Question" type="submit" style="font-size:9pt;" onchange="onQuestionSelect()" required>
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
                    </div>
                </div>

                <div hidden class="col-md-4">
                    <div class="mb-3">
                        <label for="id_question_select" class="form-label">Id de la question selectionné</label>
                        <input type="text" class="form-control" name="id_question_select" id="id_question_select" value="">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="Response" class="form-label">Réponse<font color="red">*</font>:</label>
                        <input type="text" class="form-control" name="Response" id="Response" title="Réponse des utilisateurs à leurs questions">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php if (isset($_POST['Delete_user']) || isset($_POST['Create_user']) || isset($_POST['Update_user'])) {
                        echo '<div class="text-danger">' . $msg_conf . '</div>';
                    } ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary me-2" name="Create_user" value="Créer" title="Créer le nouvel utilisateur avec les informations renseignées." />
                        <input type="submit" class="btn btn-primary me-2" name="Update_user" value="Mise à jour" title="Mettre à jour les informations renseignées dans les champs" />
                        <input type="submit" class="btn btn-danger" name="Delete_user" value="Supprimer" title="Supprimer l'utilisateur sélectionné dans le tableau ci-dessous" />
                    </div>
                </div>
            </div>
        </div>

    </form>

    <div class="container">
        <table id="t04" class="table table-bordered table-striped" style="margin-top: 20px;">
            <thead>
                <tr>
                    <th style="width: 3%">X</th>
                    <th style="width: 14%">ID</th>
                    <th style="width: 15%">Nom</th>
                    <th style="width: 16%">Prénom</th>
                    <th>Email</th>
                    <th style="width: 14%">Accès</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('CGT_Connexion_DB.php');
                //$requete = 'SELECT * FROM users ORDER BY Prenom ASC;';
                $requete = 'SELECT users.*, secret_questions.questions
                            FROM users 
                            INNER JOIN secret_questions 
                            ON users.secret_questions_id = secret_questions.id';
                $resultat = $mysqli->query($requete);
                $rowcount = mysqli_num_rows($resultat);
                $i = 1;

                //$query = 'SELECT * FROM secret_questions WHERE id like secret_questions_id;';
                //$result = $mysqli->query($query);

                while ($row = $resultat->fetch_assoc()) {
                    echo '
                    <tr onclick="frame_update(this)">
                        <td>
                            <input type="radio" style="vertical-align:middle" id="Radio_Picked_User_' . $row['ID'] . '" name="Picked_user" value="' . $row['ID'] . '">
                        </td>
                        <td>' . $row['ID'] . '</td>
                        <td>' . $row['Nom'] . '</td>
                        <td>' . $row['Prenom'] . '</td>
                        <td>' . $row['Email'] . '</td>
                        <td hidden id="td_password_' . $i++ . '">' . $row['Password'] . '</td>
                        <td>' . $row['Acces'] . '</td>';
                        //$ligne = $result->fetch_assoc();
                        echo '<td hidden id="td_question_' . $i++ . '">' . $row['questions'] . '</td>
                        <td hidden>' . $row['responses'] . '</td>
                    </tr>';
                }
                $mysqli->close();
                ?>
            </tbody>
        </table>
        <p>-- Légende Accès --</p>
        <ul>
            <li>"1" = Administrateur</li>
            <li>"2" = Utilisateur</li>
            <li>"3" = Utilisateur (blocage de commentaire)</li>
        </ul>
    </div>
</body>

</html>