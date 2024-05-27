<div class="tree">
    <nav class="navbar navbar-light ">
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" 
                data-bs-target="#button-container"" aria-controls="button-container" 
                aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    </nav>
    <div id="button-container" class="collapse">
        <?php
        if (isset($_SESSION["pseudo"])) {
        ?>
            <a href="/User/logout" class="button">Deconnexion</a>
            <a href="/User/membre" class="button">Compte</a>
            <a href="/Game/start" class="button">Jeu</a>
        <?php
        } else {
            ?>

            <a href="/User/login" class="button">Connexion</a>
            <a href="/User/signIn" class="button">Inscription</a>
        <?php
        }
        ?>

        <a href="/Default/accueil" class="button">Accueil</a>
    </div>
    
</div>