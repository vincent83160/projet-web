<!DOCTYPE html>
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/base.html';
?>

<head>
   <title>Mon compte</title>
   <link rel="stylesheet" href="/public/assets/css/account.css">
   <link rel="icon" href="/public/assets/img/logo.webp" />
</head>

<body>
   <div id="container-div-centrale">
      <div id="div-centrale">
         <div class="div-logo">
            <img src="/public/assets/img/logo.webp" width="175" height="100" alt="Plein la bobine !">
         </div>
         <div >
            <h1>Félicitation, vous etes inscrit</h1>
            <p>Vous allez bientot recevoir un mail pour confirmer votre compte</p>
            <div id="div-button">
                <a href=/Default/accueil class="btn btn-primary">OK</a>
            </div>    
        </div>
      </div>
</body>