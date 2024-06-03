<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Plein la bobine !</title>
    <link rel="icon" href="/public/assets/img/logo.webp" />

    <link rel="stylesheet" href="/public/assets/css/game.css">
    <?php
    include 'base.html';
    ?>
</head>

<body>
    <!-- HEADER -->
    <div class="wrapper">
        <div class="one"><img src="/public/assets/img/logo.webp" width="100" height="100" class="rounded-corners" alt="Plein la bobine !"></div>
        <div class="two">
            <h1>Plein la bobine !</h1>


        </div>
        <?php include 'navbar.php'; ?>

    </div>

  
    <div class="container2">
    <h4>Il semblerait que vous n'ayez pas accès à cette page</h4>
    </div>

</body>
<input type="hidden" value="0" id="dateLow" />
<input type="hidden" value="10000" id="dateUp" />
<script src="/public/assets/js/ajaxJeu.js"></script>
<script src="/public/assets/js/initJeu.js"></script>
<script src="/public/assets/js/jeu.js"></script>

</html>