<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/base.html';
?>

<head>
   <title>Mon compte</title>
   <link rel="stylesheet" href="/public/assets/css/account.css">
   <link rel="icon" href="/public/assets/img/logo2.png" />
</head>

<div>
   <a href="/Default/game" class="btn btn-primary top-left">Retour</a></a>
   <?php
   if ($_SESSION['role'] == 'ADMIN') {
      echo '<a href="/Default/game" class="btn btn-dark top-left2">Vue Admin</a>';
   }
   ?>
</div>


<body>
   <div id="div-login">
      <div class="div-logo">
         <img src="/public/assets/img/logo2.png" alt="Plein la bobine !">
      </div>
      <form method="post" id="formulaire" action="/User/userModif/">
         <div class="mb-3">
            <p>Changer votre pseudo :

            </p>
            <input class="form-control" type="text" id="username" name="login" required value="<?php
                                                                                                      echo $_SESSION['login'];
                                                                                                      ?>" />
         </div>
         <div class="mb-3">
            <p>Changer votre email :

               <input class="form-control" type="email" id="email" name="email" value="          <?php
                                                                                                   echo $_SESSION['email'];
                                                                                                   ?>" required />
         </div>
         <div class="div-submit">
            <button class="btn btn-primary" id="btn-login" type="submit">Modifier les informations</button>
         </div>
         <div class="div-submit">
            <a href="/User/logout" class="btn btn-danger">Déconnexion</a>
         </div>
      </form>
   </div>


   <script src="/public/assets/js/account.js"></script>
   <script src="/public/assets/js/connexion.js"></script>
   <script src="/public/assets/js/inscription.js"></script>
</body>