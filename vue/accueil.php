<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Plein la bobine !</title>
    <link rel="icon" href="/public/assets/img/logo.webp" />
    <?php include 'base.html'; ?>
</head>

<body>
    <!-- HEADER -->
    <div class="wrapper">
        <div class="one"><img width="100" height="100" src="/public/assets/img/logo.webp" class="rounded-corners" alt="Plein la bobine !"></div>
        <div class="two">
            <h1>Plein la bobine !</h1>
        </div>
        <?php
        include 'navbar.php';
        ?>
    </div>

    <!-- BODY -->
    <div class="holy-grail-grid">
        <main class="main-content">
            <img src="/public/assets/img/img.webp" width="250" height="250" class="rounded-corners2" alt="Illustration">
        </main>
        <section class="left-sidebar">
            <h2>Les règles : </h2>
            <h3>Bienvenue sur Pleinlabobine : </h3>
            <h3>Tous les jours, tentez de trouver le film du jour.</h3>
            <p>Suivant vos essais, les informations en commun avec le film du jour apparaîtrons.</p>
        </section>
        <aside class="right-sidebar">
            <h2>Inscrivez vous ou connectez vous : </h2>
            <h3>Pour participer il vous faut un compte.</h3>
            <p>Une validation par e-mail sera nécessaire.</p>
            <p>À vous de jouer !</p>
        </aside>
    </div>
    <div id="button-ToGame">
        <?php
        if (isset($_SESSION["pseudo"])) {
        ?>

            <a href="/game/game" class="button">Jouer</a>

        <?php
        }
        ?>
    </div>

</body>

</html>