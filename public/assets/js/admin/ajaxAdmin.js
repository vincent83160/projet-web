function ajaxDeleteByContext(idElem, context) {
  url = "../../ajax/deleteByContext/idElem=" + idElem + "/context=" + context;
  console.log(url)
  $.ajax({
    url: url,
    type: "GET",
    success: function (reponse) {
      $("#tr-" + idElem).remove();
    },
    error: function (reponse, statut, erreur) {
      console.log(reponse);
      console.log(erreur);
    },
  });
}




function ajaxGetFilmByTitre(query) {
  url = "../../ajax/getFilmByTitre/query=" + query;
  $.ajax({
    url: url,
    type: "GET",
    dataType: "json",
    success: function (reponse) {
      // reponse = JSON.parse(reponse);
      $("#list-suggestions").html("");

      html = "";

      $.each(reponse, function (index, film) { 
        if (film["bdd"]) {
          filmBdd = "filmBdd";
        } else {
          filmBdd = "suggestion";
        }

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
      console.log(reponse);
      console.log(erreur);
    },
  });
}


function ajaxAddFilm(id) {
  toggleSpinner("show");
  $("#input-film").val(""); 
  url = "../../ajax/addFilm/idFilm=" + id;

  toggleSpinner("show");
  $.ajax({
    url: url,
    type: "GET",
    success: function () {
      toggleSpinner("hide");
    },
    error: function (reponse, statut, erreur) {
      console.log(reponse);
      console.log(erreur);
    },
  })
  toggleSpinner("hide");
}
