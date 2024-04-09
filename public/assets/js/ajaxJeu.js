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
if(reponse.length == 0){
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
    },
    error: function (reponse, statut, erreur) {
      console.log(reponse);
      console.log(erreur);
    },
  });
}
