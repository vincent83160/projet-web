

$(function () {
    nbEssais = 0;
    $("#input-film").focus();
    $("#input-film").on("input", function () {
        if ($(this).val().length >= 3) {
            ajaxGetFilmByTitre($(this).val());
            $("#list-suggestions").show();
        } else {
            $("#list-suggestions").hide();
        }
    });


    $('#form input').on('keydown', function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    });

});
