

$(function () {

    $("#input-film").focus();
    $("#input-film").on("input", function () {
        if ($(this).val().length >= 3) {
            ajaxGetFilmByTitre($(this).val());
            $("#list-suggestions").show();
        } else if ($(this).val().length == 0) {

            $("#list-suggestions").remove();
            $("#list-suggestions").hide();

        } else {
            $("#btn-ajouter").prop("disabled", true);
            $("#list-suggestions").hide();
        }
    });


});
