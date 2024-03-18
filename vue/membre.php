<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/base.html';
?>

<head>
   <title>Mon compte</title>
   <link rel="stylesheet" href="/public/assets/css/account.css">
   <link rel="icon" href="/public/assets/img/logo2.png" />
</head>

<div>
   <a href="/User/logout" class="btn btn-primary top-left">Retour</a></a>
   <?php
   if ($_SESSION['user']->getRole() == 'ADMIN') {
      echo '<a href="/User/logout" class="btn btn-dark top-left2">Vue Admin</a>';
   }
   ?>
</div>


<body>
   <div id="div-login">
      <div class="div-logo">
         <img src="/public/assets/img/logo2.png" alt="Plein la bobine !">
      </div>
      <form method="post" id="formulaire" action="">
         <div class="mb-3">
            <p>Changer votre pseudo :
               <?php
               echo $_SESSION['user']->getPseudo();
               ?>
            </p>
            <input class="form-control" type="text" id="username" name="login" value="" required />
         </div>
         <div class="mb-3">
            <p>Changer votre email :
               <?php
               echo $_SESSION['user']->getEmail();
               ?>
               <input class="form-control" type="email" id="email" name="email" required />
         </div>
         <div class="div-submit">
            <button class="btn btn-primary" id="btn-login" type="submit">Modifier les informations</button>
         </div>
         <div class="div-submit">
            <a href="/User/logout" class="btn btn-danger">Déconnexion</a>
         </div>
      </form>
   </div>
</body>