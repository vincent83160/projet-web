src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"


$('#password').on(
    'keyup',function(){
        if($(this).val().length<8){
            $('#warningLength').show();
            $('#warningLength').html('Mot de passe trop court');
        }
        else{
            $('#warningLength').hide();
        }    
        if(/\d/.test($(this).val())){
            $('#warningNumber').hide();
        }
        else{
            $('#warningNumber').show();
            $('#warningNumber').html('Mot de passe doit contenir un chiffre');
        }   
        if(/[A-Z]/.test($(this).val())){
            $('#warningUpperCase').hide();
        }
        else{
            $('#warningUpperCase').show();
            $('#warningUpperCase').html('Mot de passe doit contenir une majuscule');
        } 
    }
);

$('#formulaire').submit(function(event) {
    // Empêcher l'envoi par défaut du formulaire
    event.preventDefault();
    
    // Vérifier les conditions avant d'autoriser l'envoi du formulaire
    var champ1 = $('#password').val();
    var champ2 = $('#mdp').val()

    // Par exemple, vérifier si les champs ne sont pas vides
    if (champ1.trim() === '' || champ2.trim() === ''|| champ1.length<8 || !/\d/.test(champ1) || !/[A-Z]/.test(champ1) ) {
        // Afficher un message d'erreur
        alert('Veuillez remplir tous les champs');
        // Arrêter le traitement
        return;
    }
    if(champ1!=champ2) {
        // Afficher un message d'erreur
        alert('Mots de passe différents');
        // Arrêter le traitement
        return;
    }
    $('#mdp').prop('disabled', true);
    // Si les conditions sont satisfaites, vous pouvez autoriser l'envoi du formulaire
    // Vous pouvez également effectuer d'autres opérations de validation ici
    // et envoyer le formulaire avec ajax si nécessaire
    $(this).unbind('submit').submit();
});