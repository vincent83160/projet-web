function ajaxGetFilmByTitre(query) {
  url = "../../Ajax/getFilmByTitre/query=" + query;
  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (reponse) {
      // reponse = JSON.parse(reponse);
      console.log(reponse)
      $("#list-suggestions").html("");
      html = "";
      if (reponse.length == 0) {
        $("#list-suggestions").hide();
      }
      $.each(reponse, function (index, film) {
        html += "<div class='suggestion row' id='" + film.id + "'>";
        html += "<div class='col-3'>";
        html += "<img src='https://image.tmdb.org/t/p/w92" + film.affiche + "' class='img-fluid'>";
        html += "</div>";
        html += "<div class='col-9'>";
        html += "<h6>" + film.nom + "</h6>";
        html += "<p>" + film.date_sortie.split("-")[0] + "</p>";
        html += "</div>";
        html += "</div>";
      }
      );


      html += "</div>"
      $("#list-suggestions").html(html);

      $(".suggestion").off();
      $(".suggestion").click(function () {
        id = $(this).attr("id");
        ajaxCheckIfFilmCorrect(id);
      });
    },
    error: function (reponse, statut, erreur) {
      console.log(reponse);
      console.log(erreur);
    },
  });
}


function ajaxCheckIfFilmCorrect(id) {
  nbEssais++;
  url = "../../Ajax/checkIfFilmCorrect/idFilm=" + id;

  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (reponse) {
      console.log(reponse)
      if (reponse["isCorrect"] == true) {
      } else {


        $("#list-suggestions").html("");
        if (nbEssais == 1) {
          html = nbEssais + " réponse";
        } else {
          html = nbEssais + " réponses";
        }
        $("#nbEssais").html(html);

        // htmlFilm += "<p>Acteurs " + reponse["acteursCommuns"].length + "/" + reponse["filmChecked"]["acteurs"].length + "</p>";


        htmlFilm = "<div class='card' id='essai-" + nbEssais + "'>";
        htmlFilm += "<h4>" + reponse["filmChecked"]["nom"] + "</h4>";
        htmlFilm += "<p>Acteurs</p>"; 
        htmlFilm += "<div class='row scrollable-row'>";
        $.each(reponse["acteursCommuns"], function (index, acteur) {
          htmlFilm += "<div class='acteur'>";
          if (acteur["image"] != null) {
            htmlFilm += "<div><img src='https://image.tmdb.org/t/p/w185/" + acteur["image"] + "'></div>";
          } else {
            htmlFilm += "<div><img class='anonyme' src='/public/assets/img/anonyme.png'></div>";
          }
          htmlFilm += "<p>" + acteur.name + "</p>";
          htmlFilm += "</div>";
        });
        htmlFilm += "</div>";
        console.log(htmlFilm)
        $("#container-essais").append(htmlFilm)
        $("#essai-" + nbEssais).css("background-image", "url('https://image.tmdb.org/t/p/w500" + reponse["filmChecked"]["affiche"] + "')");
        $("#essai-" + nbEssais).css("background-size", "cover");
        $("#essai-" + nbEssais).css("background-position", "center");
      }
    },
    error: function (reponse, statut, erreur) {
      console.log(reponse);
      console.log(erreur);
    },
  });
}
