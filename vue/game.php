<!DOCTYPE html>
<html>

<head>
    <title>Plein la bobine !</title>
    <link rel="icon" href="/public/assets/img/logo2.png" />

    <link rel="stylesheet" href="/public/assets/css/game.css">
    <?php
    include 'base.html';
    ?>
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
    <div class="container2">
        <img src="/public/assets/img/img.jpg" class="rounded-corners" alt="Illustration">
    </div>
    </div>

    <div class="container2">
        <form action="">
            <div class="fields">
                <span>
                    <input id="input-film" placeholder="Tapez le nom d'un film" type="text" />

                </span>
                <span id="container-list-suggestions">
                    <div id="list-suggestions"></div>

                </span>
                <span>
                    <div id="filmToFind">


                    </div>
                </span>
                <span>
                    <p id="nbEssais"></p>
                    <div class="container" id="container-essais">


                    </div>
                </span>
        </form>
    </div>

</body>

<script src="/public/assets/js/ajaxJeu.js"></script>
<script src="/public/assets/js/initJeu.js"></script>

</html>