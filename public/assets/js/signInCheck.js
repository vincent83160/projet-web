/*mdp = document.getElementById('password');

mdp.addEventListener('input',function (){
    console.log(mdp.value);
    console.log(mdp.value.length);
    if(this.value.length<13){
        showWarning()
        warningLength("Mot de passe trop court")
    }
    if(/d/.test(this.value)){
        showWarning()
        warningNumber("Mot de passe doit contenir un chiffre")
    }
    else {
    // If the input is empty, hide the warning
        hideWarning();
    }

})

function showWarning(){
    warningElement = document.getElementById("warning");
    if (warningElement) {   
        warningElement.style.display = 'block';
      }
}

function warningLength(message){
    showWarning()
    const warningElement = document.getElementById('warningLength');
    if (warningElement) {   
      warningElement.textContent = message ;
      warningElement.style.display = 'block';
    }
}

function warningNumber(message){
    showWarning()
    const warningElement = document.getElementById('warningNumber');
    if (warningElement) {   
      warningElement.textContent = message ;
      warningElement.style.display = 'block';
    }
}

function hideWarning() {
    const warningElement = document.getElementById('warning');
    if (warningElement) {
      warningElement.textContent = '';
      warningElement.style.display = 'none';
    }
  }
*/

src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"


$('#password').on(
    'keyup',function(){
        if($(this).val().length<13){
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
    var champ1 = $('#username').val();
    var champ2 = $('#password').val();
    var champ3 = $('#mail').val()

    // Par exemple, vérifier si les champs ne sont pas vides
    if (champ1.trim() === '' || champ2.trim() === ''|| champ2.length<13 || !/\d/.test(champ2) || !/[A-Z]/.test(champ2) || champ3.trim() === '   ') {
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
    
