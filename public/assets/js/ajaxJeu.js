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
      $("#list-suggestions").show();
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
        $("#list-suggestions").hide();
        if (nbEssais == 1) {
          html = nbEssais + " réponse";
        } else {
          html = nbEssais + " réponses";
        }
        $("#nbEssais").html(html);

        // htmlFilm += "<p>Acteurs " + reponse["acteursCommuns"].length + "/" + reponse["filmChecked"]["acteurs"].length + "</p>";


        htmlFilm = "<div class='card essai' id='essai-" + nbEssais + "'>";
        htmlFilm += "<h4>" + reponse["filmChecked"]["nom"] + "</h4>";
        //infos film
        htmlFilm += "<div class='row container-details'>";
        $.each(reponse["genresCommuns"], function (index, genre) {
          htmlFilm += "<div class='details'>" + genre + "</div>";
        });
        $.each(reponse["genresNonCommuns"], function (index, genre) {
          htmlFilm += "<div class='details-barre'>" + genre + "</div>";
        });
        htmlFilm += "</div>";





        htmlFilm += "<div class='row container-details'>";
        htmlFilm += "<div class='row details'>";


        //si les dates de sortie sont les mêmes
        if (reponse["filmChecked"]["date_sortie"] == reponse["filmToFind"]["date_sortie"]) {
          html += reponse["filmChecked"]["date_sortie"];

          //si le film checké est sorti entre dateUp et dateLow

        } else if (reponse["filmChecked"]["date_sortie"] < $("#dateUp").val() || reponse["filmChecked"]["date_sortie"] > $("#dateLow").val()) {

          //si le film à trouver est sorti après le film checké
          if (reponse["filmToFind"]["date_sortie"] < reponse["filmChecked"]["date_sortie"] && reponse["filmChecked"]["date_sortie"] < $("#dateUp").val()) {
            $("#dateUp").val(reponse["filmChecked"]["date_sortie"]);
          }

          if (reponse["filmToFind"]["date_sortie"] > reponse["filmChecked"]["date_sortie"] && reponse["filmChecked"]["date_sortie"] > $("#dateLow").val()) {
            $("#dateLow").val(reponse["filmChecked"]["date_sortie"]);
          }



          let dateLow = $("#dateLow").val();
          let dateUp = $("#dateUp").val();
          if (dateUp != 10000 && dateLow != 0) {
            htmlFilm += "Entre " + dateLow + " et " + dateUp;
          } else if ($("#dateUp").val() != 10000) {
            htmlFilm += "Avant " + dateUp;
          } else if ($("#dateLow").val() != 0) {
            htmlFilm += "Après " + dateLow;
          }

        }
        htmlFilm += "</div>"
        htmlFilm += "</div>"



        htmlFilm += "<p>Acteurs</p>";
        htmlFilm += "<div class='row scrollable-row'>";



        //acteurs
        $.each(reponse["acteursCommunsDetails"], function (index, acteur) {
          htmlFilm += "<div class='acteur'>";
          if (acteur["image"] != null) {
            htmlFilm += "<img class='img-acteur' src='https://image.tmdb.org/t/p/w92/" + acteur["image"] + "'>";
          } else {
            htmlFilm += "<img class='anonyme' src='/public/assets/img/anonyme.png'>";
          }
          htmlFilm += "<p class='acteur-nom'>" + acteur.name + "</p>";
          htmlFilm += "</div>";
        });
        $.each(reponse["acteursNonCommunsDetails"], function (index, acteur) {
          htmlFilm += "<div class='acteur'>";
          if (acteur["image"] != null) {
            htmlFilm += "<img class='img-acteur noir-et-blanc' src='https://image.tmdb.org/t/p/w92/" + acteur["image"] + "'>";
          } else {
            htmlFilm += "<div><img class='anonyme' src='/public/assets/img/anonyme.png'></div>";
          }
          htmlFilm += "<p class='texte-barre acteur-nom'>" + acteur.name + "</p>";
          htmlFilm += "</div>";
        });

        htmlFilm += "</div>";
        $("#container-essais").prepend(htmlFilm)
        $("#essai-" + nbEssais).css("background-image", "linear-gradient(rgb(40, 31, 74) 2%, rgba(40, 31, 74, 0.7) 50%, rgb(40, 31, 74) 98%), url('https://image.tmdb.org/t/p/w500" + reponse["filmChecked"]["affiche"] + "')");
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
