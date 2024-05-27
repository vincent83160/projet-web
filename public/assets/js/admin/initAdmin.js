

$(function () {
    $("#table").DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/fr-FR.json",
        },
    });


    $(".btn-delete").on("click", function () {
        if (confirm("Voulez-vous vraiment supprimer cet élément ?")) {
            ajaxDeleteByContext($(this).attr("id"), $("#context").val());
        }
    });



    $("#input-film").focus();
    $("#input-film").on("input", function () {
        if ($(this).val().length >= 2) {
            ajaxGetFilmByTitre($(this).val());
            $("#list-suggestions").show();
        
        } else { 
            $("#list-suggestions").hide();
        }
    });

});
