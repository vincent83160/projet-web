<div class="tree">
    <div id="button-container">
        <?php
        if ($_SESSION["login"]) {
        ?>
            <a href="/User/logout" class="button">Deconnexion</a>
            <a href="/User/membre" class="button">Compte</a>

        <?php
        } else {
        ?>

            <a href="/User/login" class="button">Connexion</a>
            <a href="#" class="button">Inscription</a>
        <?php
        }
        ?>

            <a href="/Default/accueil" class="button">Accueil</a>
    </div>
</div>