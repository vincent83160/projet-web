<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/base.html';
?>

<head>
   <title>Changer mot de passe</title>
   <link rel="stylesheet" href="/public/assets/css/account.css">
   <link rel="icon" href="/public/assets/img/logo2.png" />
</head>
<?php
include 'navbar.php';
?>
<body>
   <div id="container-div-centrale">
      <div id="div-centrale">
         
         <form method="post" id="formulaire" action="/User/userModif/">
           
            <div class="mb-3">
               <p>Nouveau mot de passe :
               </p>
               <input class="form-control" type="password" id="password" name="password" required />
            </div>
            <div id="warning" style=" color: red;">
                <div id="warningLength" style="display: none; "></div>
                <div id="warningNumber" style="display: none; "></div>
                <div id="warningUpperCase" style="display: none; "></div>
            </div>
            <div class="mb-3">
               <p>Confirmer mot de passe :
               </p>
               <input class="form-control" type="text" id="mdp" name="mdp" />
            </div>
            <input type="hidden" name="id" required value="<?php echo $_SESSION['id'];?>" />
            <div class="div-submit">
               <button class="btn btn-primary" id="btn-login" type="submit">Modifier les informations</button>
            </div>
         </form>
      </div>
    </div>
</body>

<script src="/public/assets/js/modifPwdCheck.js"></script>