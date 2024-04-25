<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <title>Site d'actualités</title>

  <style>
    body {
      font-family: "Helvetica Rounded", "Arial Rounded MT Bold", Arial, sans-serif;
    }

    .custom-navbar {
      background-color: #E31800;
      /* Remplace cette valeur par ta couleur personnalisée */
      /* Ajoute d'autres styles personnalisés si nécessaire */
    }

    #title {
      font-weight: bold;
    }

    .no-resize {
      resize: none;
      border: none;
      background-color: white;
    }

    .custom-button {
      background-color: #E31800;
      color: white;
      text-align: center;
    }
  </style>


  <script>
    function adjustTextareaHeight() {
      const textarea = document.getElementById('myTextarea');
      textarea.style.height = 'auto';
      textarea.style.height = textarea.scrollHeight + 'px';
    }

    window.addEventListener('DOMContentLoaded', adjustTextareaHeight);
  </script>

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light custom-navbar">
  <?php
    if ($_SESSION['Acces'] != "1") {
      echo '<a id="title" class="navbar-brand" href="index.php">La CGT Montjoie</a>';
    } else {
    echo '<a id="title" class="navbar-brand" href="index.php">Administrateur</a>';
    }
    echo '<div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">';
        if ($_SESSION['Acces'] != "1") {
        echo '<li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>';
        } else {
        echo '<li class="nav-item"><a class="nav-link" href="add_categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="get_articles.php">Voir / Supprimer Articles</a></li>
        <li class="nav-item"><a class="nav-link" href="add_articles.php">Ajouter Articles</a></li>
        <li class="nav-item"><a class="nav-link" href="users.php">Utilisateurs</a></li>
        <li class="nav-item"><a class="nav-link" href="admin_messages.php">Notifications<span id="notification-counter" class="badge badge-danger">0</span></a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Déconnexion</a></li>';
        }
      echo '</ul>
    </div>';
  ?>
</nav>
</body>
</html>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    // Fonction pour mettre à jour le compteur de notifications
    function updateNotificationCounter() {
        fetch('admin_notification_count.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('notification-counter').textContent = data.notification_count;
        })
        .catch(error => {
            console.error('Erreur lors de la récupération du nombre de notifications:', error);
        });
    }

    // Appel de la fonction pour mettre à jour le compteur de notifications au chargement de la page
    updateNotificationCounter();

    // Lorsque l'utilisateur clique sur l'onglet "Notifications", marquer toutes les notifications comme lues
    document.querySelector('a[href="admin_messages.php"]').addEventListener('click', function() {
        fetch('admin_notification_mark_as_read.php', {
            method: 'POST'
        })
        .then(() => {
            // Mettre à jour le compteur de notifications après avoir marqué comme lues
            updateNotificationCounter();
        })
        .catch(error => {
            console.error('Erreur lors du marquage des notifications comme lues:', error);
        });
    });
});

</script>