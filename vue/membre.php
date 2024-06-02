<!DOCTYPE html>
<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/base.html';
?>

<head>
   <title>Mon compte</title>
   <link rel="stylesheet" href="/public/assets/css/account.css">
   <link rel="icon" href="/public/assets/img/logo2.png" />
</head>
<?php
include 'navbar.php';
?>

<body>
   <div id="container-div-centrale">
      <div id="div-centrale">
         <div class="div-logo">
            <img src="/public/assets/img/logo2.png" alt="Plein la bobine !">
         </div>
         <form method="post" id="formulaire" action="/User/userModif/">
            <input type="hidden" name="id" required value="<?php echo $_SESSION['id']; ?>" />
            <div class="mb-3">
               <p>Changer votre pseudo :
               </p>
               <input class="form-control" type="text" id="username" name="pseudo" required value="<?php echo $_SESSION['pseudo']; ?>" />
            </div>
            <div class="mb-3">
               <p>Changer votre email :</p>

               <input class="form-control" type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" required />
            </div>
            <div class="div-submit">
               <a href="/user/mdp" class="btn btn-primary" id="btn-mdp">Modifier mot de passe</a>
            </div>
            <div class="div-submit">
               <button class="btn btn-primary" id="btn-login" type="submit">Modifier les informations</button>
            </div>
            <div class="div-submit">
               <a href="/user/logout" class="btn btn-danger">Déconnexion</a>
            </div>
         </form>
      </div>



</body>