 <!DOCTYPE html>

 <head>
     <?php

        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/base.html';
        ?>
     <title>Inscription pour plein la bobine !</title>
     <link rel="stylesheet" href="/public/assets/css/login.css">
     <link rel="icon" href="/public/assets/img/logo2.png" />
 </head>
 <?php include 'navbar.php'; ?>
 <div id="fond-login">
 </div>
 <div id="container-div-centrale">
     <div id="div-login">
         <div class="div-logo">
             <img src="/public/assets/img/logo2.png" alt="Plein la bobine !">
         </div>
         <h1>Inscription</h1>
         <form method="post" id="formulaire" action="/User/signIn">
             <div class="mb-3">
                 <label class="form-label" for="username">Pseudo:</label>
                 <input class="form-control" type="text" id="username" name="pseudo" required />
             </div>
             <div class="mb-3">
                 <label class="form-label" for="password">Mot de passe:</label>
                 <input class="form-control" type="password" id="password" name="password" required />
             </div>
             <div id="warning" style=" color: red;">
                 <div id="warningLength" style="display: none; "></div>
                 <div id="warningNumber" style="display: none; "></div>
                 <div id="warningUpperCase" style="display: none; "></div>
             </div>
             <div class="mb-3">
                 <label class="form-label" for="username">Mail:</label>
                 <input class="form-control" type="text" id="mail" name="mail" required />
             </div>
             <div class="div-submit">
                 <button class="btn btn-primary" id="btn-login" type="submit">S'inscrire</button>
             </div>
         </form>
     </div>
 </div>
 <script src="/public/assets/js/signInCheck.js"></script>