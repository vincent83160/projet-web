<!DOCTYPE html>
<html>

<head>
    <title>Plein la bobine !</title>
    <link rel="stylesheet" href="/public/assets/css/style.css">
    <link rel="icon" href="/public/assets/img/logo2.png" />
</head>

<body>
    <!-- HEADER -->
    <div class="wrapper">
        <div class="one"><img src="/public/assets/img/logo2.png" class="rounded-corners" alt="Plein la bobine !"></div>
        <div class="two">
            <h1>Plein la bobine !</h1>
        </div>
        <div class="tree">
            <div id="button-container">
                <?php
                    if (isset($_SESSION["user"]) && $_SESSION["login"]){
                        ?> 
                            <a href="/logout" class="button">Deconnexion</a>
                            <a href="/membre" class="button">Compte</a>
                        <?php
                    }
                ?>

                <a href="/login" class="button">Connexion</a>
                <a href="#" class="button">Inscription</a>
            </div>
        </div>
    </div>

    <!-- BODY -->
    <div class="holy-grail-grid">
        <main class="main-content">
            <img src="/public/assets/img/img.jpg" class="rounded-corners2" alt="Illustration">
        </main>
        <section class="left-sidebar">
            <h2>Les règles : </h2>
            <h3>Bienvenue sur Pleinlabobine.fr : </h3>
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
    
</body>

</html>
