// Fonction pour supprimer un élément selon le contexte via une requête AJAX
function ajaxDeleteByContext(idElem, context) {
  // Construction de l'URL avec les paramètres idElem et context
  url = "../../ajax/deleteByContext/idElem=" + idElem + "/context=" + context;
  console.log(url);
  
  // Envoi de la requête AJAX
  $.ajax({
    url: url,
    type: "GET",
    success: function (reponse) {
      // Suppression de l'élément HTML correspondant à idElem en cas de succès
      $("#tr-" + idElem).remove();
    },
    error: function (reponse, statut, erreur) {
      // Affichage des erreurs en cas d'échec
      console.log(reponse);
      console.log(erreur);
    },
  });
}

// Fonction pour obtenir un film par son titre via une requête AJAX
function ajaxGetFilmByTitre(query) {
  // Construction de l'URL avec le paramètre query
  url = "../../ajax/getFilmByTitre/query=" + query;
  
  // Envoi de la requête AJAX
  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (reponse) {
      // Mise à jour de la liste des suggestions
      $("#list-suggestions").html("");
      html = "";

      // Parcourir chaque film dans la réponse
      $.each(reponse, function (index, film) { 
        if (film["bdd"]) {
          filmBdd = "filmBdd";
        } else {
          filmBdd = "suggestion";
        }

        // Construction de l'HTML pour chaque film
        html += "<div class='" + filmBdd + " row' id='" + film.id + "'>";
        if (film["bdd"]) {
          html += "<h4>Ce film est déjà présent en base de données</h4>";
        }
        html += "<div class='col-3'>";
        html += "<img src='https://image.tmdb.org/t/p/w92" + film.poster_path + "' class='img-fluid'>";
        html += "</div>";
        html += "<div class='col-9'>";
        html += "<h6>" + film.original_title + "</h6>";
        html += "<p>" + film.release_date.split("-")[0] + "</p>";
        html += "</div>";
        html += "</div>";
      });

      html += "</div>";
      $("#list-suggestions").show();
      if (reponse.length == 0) {
        $("#list-suggestions").hide();
      }
      $("#list-suggestions").html(html);

      // Gestion des clics sur les suggestions de films
      $(".suggestion").off();
      $(".suggestion").click(function () {
        id = $(this).attr("id");        
        ajaxAddFilm(id);
        $("#input-film").val("");
        $("#list-suggestions").html("");
        $("#list-suggestions").hide();
      });
    },
    error: function (reponse, statut, erreur) {
      // Affichage des erreurs en cas d'échec
      console.log(reponse);
      console.log(erreur);
    },
  });
}

// Fonction pour ajouter un film via une requête AJAX
function ajaxAddFilm(id) {
  toggleSpinner("show");
  $("#input-film").val(""); 
  // Construction de l'URL avec le paramètre idFilm
  url = "../../ajax/addFilm/idFilm=" + id;

  toggleSpinner("show");
  // Envoi de la requête AJAX
  $.ajax({
    url: url,
    type: "GET",
    success: function () {
      // Cacher le spinner en cas de succès
      toggleSpinner("hide");
    },
    error: function (reponse, statut, erreur) {
      // Affichage des erreurs et cacher le spinner en cas d'échec
      console.log(reponse);
      console.log(erreur);
      toggleSpinner("hide");
    },
  });
}
