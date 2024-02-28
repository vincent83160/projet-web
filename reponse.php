<?php
if (isset($_SESSION['login']) && isset($_SESSION['password'])) {
    echo "Bonjour " . $_SESSION['login'] . " vous êtes connecté";
} else {
    if (isset($_POST['login']) && isset($_POST['password'])) {
        if ($_POST['login'] == "toto" && $_POST['password'] == "toto") {
             
            $_SESSION['login'] = $_POST['login'];
            $_SESSION['password'] = $_POST['password'];
            require("acceuil.php");
        } else {
            $erreur = "Mauvais login ou mot de passe";
            require("index.php");
        }
    }
}
