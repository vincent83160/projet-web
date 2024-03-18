<div class="tree">
    <div id="button-container">
        <?php
        if (isset($_SESSION["user"]) && $_SESSION["login"]) {
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

         
    </div>
</div>