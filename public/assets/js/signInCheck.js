

src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"
$("#btn-login").hide();

$('#password').on(
    'keyup', function () {
        if ($(this).val().length < 8) {
            $('#warningLength').html('Mot de passe trop court');
        }
        else {
            $('#warningLength').html("");
        }
        if (/\d/.test($(this).val())) {
            $('#warningNumber').html("");
        }
        else {
            $('#warningNumber').html('Mot de passe doit contenir un chiffre');
        }
        if (/[A-Z]/.test($(this).val())) {
            $('#warningUpperCase').html("");
        }
        else {
            $('#warningUpperCase').html('Mot de passe doit contenir une majuscule');
        }
        checkEmptyWarnings()

    }
);

var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
$("#mail").on("input", function () {
    if (!emailPattern.test($(this).val())) {
        $('#warningEmail').html('Adresse e-mail invalide.');
    } else {
        $('#warningEmail').html("");
    }
    checkEmptyWarnings();


})

$('#formulaire').submit(function (event) {
    // Empêcher l'envoi par défaut du formulaire
    event.preventDefault();

    // Vérifier les conditions avant d'autoriser l'envoi du formulaire
    var champ1 = $('#username').val();
    var champ2 = $('#password').val();
    var champ3 = $('#mail').val()

    // Par exemple, vérifier si les champs ne sont pas vides
    if (champ1.trim() === '' || champ2.trim() === '' || champ2.length < 8 || !/\d/.test(champ2) || !/[A-Z]/.test(champ2) || champ3.trim() === '   ') {
        // Afficher un message d'erreur
        alert('Veuillez remplir tous les champs');
        // Arrêter le traitement
        return;
    }
    // Si les conditions sont satisfaites, vous pouvez autoriser l'envoi du formulaire
    // Vous pouvez également effectuer d'autres opérations de validation ici
    // et envoyer le formulaire avec ajax si nécessaire
    $(this).unbind('submit').submit();
});

$("#username").on("input", function () {
    checkEmptyWarnings();
});

function checkEmptyWarnings() {
    var allEmpty = true;
    $('.warning').each(function () {
        if ($.trim($(this).html()) !== '') {
            console.log($(this).attr('id'))
            allEmpty = false;
            return false; // Sort de la boucle each
        }
    });

    console.log(allEmpty)
    if ($("#username").val() == "") {
        allEmpty = false;
    }
    console.log(allEmpty)
    if (allEmpty) {
        $("#btn-login").show();
    } else {
        $("#btn-login").hide();
    }
}

