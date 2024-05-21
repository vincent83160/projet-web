

$(function () {
nbEssais = 0;
    $("#input-film").focus();
    $("#input-film").on("input", function () {
        if ($(this).val().length >= 3) {
            ajaxGetFilmByTitre($(this).val());
            $("#list-suggestions").show();
        } else if ($(this).val().length == 0) {

            $("#list-suggestions").hide();

        } else {
            $("#btn-ajouter").prop("disabled", true);
            $("#list-suggestions").hide();
        }
    });
    $('#form input').on('keydown', function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    }); 

});
