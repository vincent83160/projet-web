function ajaxGetFilmByTitre(query) {
  url = "ajaxControler.php?ajax=ajaxGetFilmByTitre";
  params = "query=" + query;

  $.ajax({
    url: url,
    type: "get",
    data: params,
    dataType: "html",
    success: function (html) {
      $("#input-film").after(html);
    },
    error: function (reponse, statut, erreur) {
      console.log(erreur);
    },
  });
}
