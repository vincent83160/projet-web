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
      console.log(reponse.length)

      $.each(reponse, function (index, film) {
        html += "<div class='suggestion row' id='" + film.id + "'>";
        html += "<div class='col-3'>";
        html += "<img src='https://image.tmdb.org/t/p/w92" + film.poster_path + "' class='img-fluid'>";
        html += "</div>";
        html += "<div class='col-9'>";
        html += "<h6>" + film.original_title + "</h6>";
        html += "<p>" + film.release_date.split("-")[0] + "</p>";
        html += "</div>";
        html += "</div>";
      }
      );


      html += "</div>"
      $("#list-suggestions").show();
      if (reponse.length == 0) {
        $("#list-suggestions").hide();
      }
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
        htmlFilm += "<h4>" + reponse["nom"] + "</h4>";
        //infos film
        htmlFilm += "<div class='row container-details'>";

        $.each(reponse["genres"], function (index, genre) {
          htmlFilm += "<div class='details'>" + genre + "</div>";
        });
        htmlFilm += "</div>";

        htmlFilm += "<div class='row container-details'>";

        //si les dates de sortie sont les mêmes 

        htmlFilm += "<div class='row details'>";
        htmlFilm += reponse["date_sortie"];
        htmlFilm += "</div>"

        htmlFilm += "<p>Acteurs</p>";
        htmlFilm += "<div class='row scrollable-row acteur-row'>";



        //acteurs

        $.each(reponse["acteurs"], function (index, acteur) {

          htmlFilm += "<div class='acteur' idActeur='" + acteur.id + "' rang='" + acteur["rang"] + "'>";

          if (acteur["image"] != null) {
            htmlFilm += "<img class='img-acteur' src='https://image.tmdb.org/t/p/w92/" + acteur["image"] + "'>";
          } else {
            htmlFilm += "<img class='anonyme' src='/public/assets/img/anonyme.png'>";
          }
          htmlFilm += "<p class='acteur-nom'>" + acteur.name + "</p>";
          htmlFilm += "</div>";
        });
        htmlFilm += "</div>";


        $("#container-filmToFind").html(htmlFilm);
        $("#essai-" + nbEssais).css("background-image", "linear-gradient(rgb(40, 31, 74) 2%, rgba(40, 31, 74, 0.7) 50%, rgb(40, 31, 74) 98%), url('https://image.tmdb.org/t/p/w500" + reponse["affiche"] + "')");
        $("#essai-" + nbEssais).css("background-size", "cover");
        $("#essai-" + nbEssais).css("background-position", "center");
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
        $.each(reponse["genre"], function (index, genre) {
          htmlFilm += "<div class='details'>" + genre + "</div>";
        });
        $.each(reponse["genresNonCommuns"], function (index, genre) {
          htmlFilm += "<div class='details-barre'>" + genre + "</div>";
        });
        htmlFilm += "</div>";







        htmlFilm += "<div class='row container-details'>";
        //si les dates de sortie sont les mêmes
        if (reponse["filmChecked"]["date_sortie"] == reponse["filmToFind"]["date_sortie"]) {

          htmlFilm += "<div class='row details'>";
          htmlFilm += reponse["filmChecked"]["date_sortie"];
          dateFilm = reponse["filmChecked"]["date_sortie"];
          //si le film checké est sorti entre dateUp et dateLow  

        } else if (reponse["filmChecked"]["date_sortie"] < $("#dateUp").val() || reponse["filmChecked"]["date_sortie"] > $("#dateLow").val()) {

          htmlFilm += "<div class='row details-barre'>";

          if (reponse["filmToFind"]["date_sortie"] > reponse["filmChecked"]["date_sortie"]) {
            htmlFilm += "Après " + reponse["filmChecked"]["date_sortie"];
            if (reponse["filmChecked"]["date_sortie"] > $("#dateLow").val()) {
              $("#dateLow").val(reponse["filmChecked"]["date_sortie"]);
            }
          } else {
            htmlFilm += "Avant " + reponse["filmChecked"]["date_sortie"];
            if (reponse["filmChecked"]["date_sortie"] < $("#dateUp").val()) {
              $("#dateUp").val(reponse["filmChecked"]["date_sortie"]);
            }
          }



          let dateLow = $("#dateLow").val();
          let dateUp = $("#dateUp").val();
          if (dateUp != 10000 && dateLow != 0) {
            dateFilm = "Entre " + dateLow + " et " + dateUp;
          } else if ($("#dateUp").val() != 10000) {
            dateFilm = "Avant " + dateUp;
          } else if ($("#dateLow").val() != 0) {
            dateFilm = "Après " + dateLow;
          }

        }
        htmlFilm += "</div>"
        htmlFilm += "</div>"
        htmlFilm += "<div class='row row-essai'>"



        htmlFilm += "<p>Acteurs</p>";
        htmlFilm += "<div class='row scrollable-row acteur-row'>";



        //acteurs

        $.each(reponse["acteurs"], function (index, acteur) {
          htmlFilm += "<div class='acteur' idActeur='" + acteur["id"] + "' rang='" + acteur["rang"] + "'>";
          if (acteur["image"] != null) {
            htmlFilm += "<img class='img-acteur' src='https://image.tmdb.org/t/p/w92/" + acteur["image"] + "'>";
          } else {
            htmlFilm += "<img class='anonyme' src='/public/assets/img/anonyme.png'>";
          }
          htmlFilm += "<p class='acteur-nom'>" + acteur.name + "</p>";
          htmlFilm += "</div>";
        });

        htmlFilm += "</div>";
        htmlFilm += "<div class='row scrollable-row real-row'>";
        $.each(reponse["realisateurs"], function (index, real) {
          htmlFilm += "<div class='realisateur'>";
          if (real["image"] != null) {
            htmlFilm += "<img class='img-realisateur' src='https://image.tmdb.org/t/p/w92/" + real["image"] + "'>";
          } else {
            htmlFilm += "<img class='anonyme' src='/public/assets/img/anonyme.png'>";
          }
          htmlFilm += "<p class='realisateur-nom'>" + real.name + "</p>";
          htmlFilm += "</div>";
        });



        htmlFilm += "</div>";
        $("#container-essais").prepend(htmlFilm)
        $("#essai-" + nbEssais).css("background-image", "linear-gradient(rgb(40, 31, 74) 2%, rgba(40, 31, 74, 0.7) 50%, rgb(40, 31, 74) 98%), url('https://image.tmdb.org/t/p/w500" + reponse["filmChecked"]["affiche"] + "')");
        $("#essai-" + nbEssais).css("background-size", "cover");
        $("#essai-" + nbEssais).css("background-position", "center");











        //div de récap sur le film à trouver 


        if ($(".essai").length == 1) {



          htmlRecap = "<div class='card essai' id='filmToFind'>";
          htmlRecap += "<h4>Film à trouver</h4>";
          //infos film
          htmlRecap += "<div class='row container-details'>";
          $.each(reponse["genresCommuns"], function (index, genre) {
            htmlRecap += "<div class='details'>" + genre + "</div>";
          });
          $.each(reponse["genresNonCommuns"], function (index, genre) {
            htmlRecap += "<div class='details-barre'>" + genre + "</div>";
          });
          htmlRecap += "</div>";
          htmlRecap += "<div class='row container-details'>";
          htmlRecap += "<div class='details' id='date-recap'>";
          htmlRecap += dateFilm;
          htmlRecap += "</div>";

          htmlRecap += "<div class='row row-nb-acteur-real'>";
          htmlRecap += "<div id='row-nbActeurs' class='row'>Acteurs <div id='nbActeursFind'>" + reponse["acteursCommunsDetails"].length + "</div>/<div id='nbActeursToFind'>" + reponse["filmToFind"]["acteurs"].length + "</div></div>";
          htmlRecap += "<div id='row-nbReals' class='row'>Réal(s) <div id='nbRealsFind'>" + reponse["realisateursCommunsDetails"].length + "</div>/<div id='nbRealsToFind'>" + reponse["filmToFind"]["realisateurs"].length + "</div></div>";
          htmlRecap += "</div>";

          htmlRecap += "<div id='find-acteur-row' class='row acteur-row scrollable-row'>";

          $.each(reponse["acteursCommunsDetails"], function (index, acteur) {

            htmlRecap += "<div class='acteur-find' idActeur='" + acteur.id + "' rang='" + acteur.rang + "'>";
            if (acteur["image"] != null) {
              htmlRecap += "<img class='img-acteur' src='https://image.tmdb.org/t/p/w92/" + acteur["image"] + "'>";
            } else {
              htmlRecap += "<img class='anonyme' src='/public/assets/img/anonyme.png'>";
            }
            htmlRecap += "<p class='acteur-nom'>" + acteur.name + "</p>";
            htmlRecap += "</div>";
          });

          $.each(reponse["acteursNonCommunsDetails"], function (index, acteur) {
            htmlRecap += "<div class='acteur' idActeur='" + acteur["id"] + "' rang='" + acteur["rang"] + "'>";

            htmlRecap += "<img class='anonyme' src='/public/assets/img/anonyme.png'>";
            htmlRecap += "<p class='acteur-nom'>&nbsp;</p>";

            htmlRecap += "</div>";
          });
          htmlRecap += "</div>";

          htmlRecap += "<div class='row scrollable-row real-row'>";
          $.each(reponse["realisateursCommunsDetails"], function (index, real) {
            htmlRecap += "<div class='realisateur'>";
            if (real["image"] != null) {
              htmlRecap += "<img class='img-realisateur' src='https://image.tmdb.org/t/p/w92/" + real["image"] + "'>";
            } else {
              htmlRecap += "<img class='anonyme' src='/public/assets/img/anonyme.png'>";
            }
            htmlRecap += "<p class='realisateur-nom'>" + real.name + "</p>";
            htmlRecap += "</div>";
          });

          $.each(reponse["realisateursNonCommunsDetails"], function (index, real) {
            htmlRecap += "<div class='real'>";

            htmlRecap += "<img class='anonyme' src='/public/assets/img/anonyme.png'>";
            htmlRecap += "<p class='realisateur-nom'>&nbsp;</p>";

            htmlRecap += "</div>";
          });
          htmlRecap += "</div>";




          $("#container-filmToFind").html(htmlRecap);
          $("#filmToFind").css("background-image", "linear-gradient(rgb(40, 31, 74) 2%, rgba(40, 31, 74, 0.7) 50%, rgb(40, 31, 74) 98%), url(/public/assets/img/fond-login.webp)");



        } else {
          $("#dateFilm").html(dateFilm);
          listActeursFind = [];
          $(".acteur-find").each(function () {
            listActeursFind[$(this).attr('rang')] = parseInt($(this).attr('idActeur'));
          });

          console.log(listActeursFind)
          $.each(reponse["acteursCommunsDetails"], function (index, acteur) {
            if (!listActeursFind.includes(acteur["rang"])) {
              listActeursFind[acteur['rang']] = parseInt(acteur["id"]);
            }
          });
          nbActeursFind = 0;
          $.each(listActeursFind, function (index, acteur) {
            if (acteur != undefined) {
              nbActeursFind++
            }
          });
          $("#nbActeursFind").html(nbActeursFind);

          htmlActeurs = "";
          $.each(listActeursFind, function (rang, acteur) {
            if (acteur != undefined) {
              htmlActeurs += "<div class='acteur-find' idActeur='" + acteur + "' rang='" + rang + "'>" + $(".acteur[idActeur='" + acteur + "']").first().html() + "</div>";
            }
          });


          let nbActeursNotFind = $("#nbActeursToFind").html() - nbActeursFind;
          for (let i = 0; i < nbActeursNotFind; i++) {
            htmlActeurs += "<div class='acteur'><img class='anonyme' src='/public/assets/img/anonyme.png'><p class='acteur-nom'>&nbsp;</p></div>";
          }
          $("#find-acteur-row").html(htmlActeurs);
        }



      }



    },
    error: function (reponse, statut, erreur) {
      console.log(reponse);
      console.log(erreur);
    },
  });
}
