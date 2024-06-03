<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Plein la bobine !</title>
    <link rel="icon" href="/public/assets/img/logo2.png">

    <link rel="stylesheet" href="/public/assets/css/game.css">
    <?php
    include 'base.html';
    ?>

    <script src="/public/assets/js/jeu/ajaxJeu.js"></script>
    <script src="/public/assets/js/jeu/initJeu.js"></script>
    <script src="/public/assets/js/jeu/jeu.js"></script>
</head>

<body>
    <!-- HEADER -->
    <div class="wrapper">
        <div class="one"><img src="/public/assets/img/logo2.png" class="rounded-corners" alt="Plein la bobine !"></div>
        <div class="two">
            <h1>Plein la bobine !</h1>


        </div>
        <?php include 'navbar.php'; ?>

    </div>

    <!-- BODY -->
    <div id="spinner"><img src="/public/assets/gif/spinner.gif" alt="spinner"></div>
    <div class="container2">
        <img src="/public/assets/img/img.jpg" class="rounded-corners3" alt="Illustration">
    </div>

    <div class="container2">
        <form id="form">

            <input type="hidden" value="0" id="dateLow">
            <input type="hidden" value="10000" id="dateUp">
            <div class="fields">
                <div>
                    <input id="input-film" placeholder="Tapez le nom d'un film" type="text">
                </div>
                <div id="container-list-suggestions">
                    <div id="list-suggestions"></div>
                </div>
                <div>
                    <div class="container" id="container-filmToFind">
                    </div>
                </div>
                <div>
                    <p id="nbEssais"></p>
                    <div class="container" id="container-essais">


                    </div>
                </div>
            </div>
        </form>
    </div>

</body>

</html>