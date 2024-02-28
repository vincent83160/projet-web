<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/model/ConnexionMySql.php';
$db = new ConnexionMySql();
$erreur = ""; 
if (isset($_SESSION['login']) && isset($_SESSION['password'])) {

    require($_SERVER["DOCUMENT_ROOT"]."/vue/jeu.php");
} else { 
    // var_dump(password_hash($_POST['password'], PASSWORD_DEFAULT));
    if ($db->checkLogin($_POST['login'], $_POST['password'])) {

        $_SESSION['login'] = $_POST['login'];
        $_SESSION['password'] = $_POST['password'];
        require($_SERVER["DOCUMENT_ROOT"]."/vue/jeu.php");
    } else {
        $erreur = "Mauvais login ou mot de passe";
        header("Location: /login.php");
    }
 
}
