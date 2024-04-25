// Fonction pour effectuer une requête AJAX et récupérer les articles depuis le serveur
function fetchArticles() {
  var xhr = new XMLHttpRequest();
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var articles = JSON.parse(xhr.responseText);
      displayArticles(articles);
    }
  };
  xhr.open("GET", "get_articles.php", true);
  xhr.send();
}

// Fonction pour afficher les articles
function displayArticles(articles) {
  var articlesContainer = document.getElementById("articles");

  // Effacer le contenu précédent
  articlesContainer.innerHTML = "";

  // Parcourir les articles
  articles.forEach(function (article) {
    var articleElement = document.createElement("div");
    articleElement.classList.add("article");

    // Titre de l'article
    var titleElement = document.createElement("h3");
    titleElement.textContent = article.title;
    articleElement.appendChild(titleElement);

    // Contenu de l'article
    var contentElement = document.createElement("p");
    contentElement.textContent = article.content;
    articleElement.appendChild(contentElement);

    articlesContainer.appendChild(articleElement);
  });
}

// Appel de la fonction pour récupérer et afficher les articles au chargement de la page
window.onload = fetchArticles;
