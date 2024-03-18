

$(function () {

$("#input-film").focus();
$("#input-film").on("input",function(){
    if($(this).val().length>=3){
        console.log("appelAjax");
        ajaxGetFilmByTitre($(this).val());
    }else{
        $("#btn-ajouter").prop("disabled",true);
    }
});


});
