function ajaxGetFilmByTitre(query) {
  console.log("Ajax appele");
  url = "/Ajax/getFilmByTitre/".query;
  params = "query=" + query;

  $.ajax({
    url: url,
    type: "post",
    data: params, 
    dataType: "html",
    success: function () {
      $("#input-film").after("<div value = 'movie 1'>movie 1</div>");
    },
    error: function (reponse, statut, erreur) {
      console.log(erreur);
    },
  });
}
