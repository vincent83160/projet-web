function ajaxGetFilmByTitre(query) {
  //console.log("Ajax appele");
  var url = "/Ajax/getFilmByTitle";
  var params =  "query="+query;

  $.ajax({
    url: url,
    type: "post",
    data: params, 
    dataType: "html",
    success: function (reponse) {
      reponse=JSON.parse(reponse);
      //reponse=Object.entries(reponse);
        //console.log(reponse);
        $("#suggestions").remove();
        $("#input-film").after("<div id='suggestions'></div>");
          $.each(reponse, function(key,film){
            console.log(film);
            $("#suggestions").append("<div><img href='https://image.tmdb.org/t/p/w92"+film.affiche+"' height=100px weight=100px>"+film.nom+"</div>");
      })

      
      
    },
    error: function (reponse, statut, erreur) {
      console.log(erreur);
    },
  });
}
