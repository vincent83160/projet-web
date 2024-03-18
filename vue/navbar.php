<div class="tree">
    <div id="button-container">
        <?php
        if (isset($_SESSION["login"])) {
        ?>
            <a href="/User/logout" class="button">Deconnexion</a>
            <a href="/User/membre" class="button">Compte</a>

            <?php
            if ($_SESSION['role'] == 'ADMIN') {
            ?>
                <a href="/Default/game" class="btn btn-dark top-left2">Vue Admin</a>
            <?php
            }
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