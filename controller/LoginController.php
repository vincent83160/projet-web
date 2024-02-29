<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
$db = new ConnexionMySql();
$erreur = "";
if (isset($_SESSION['login']) && isset($_SESSION['password'])) {

    require_once $_SERVER["DOCUMENT_ROOT"] . "/controller/DefaultController.php";
} else {
    // var_dump(password_hash($_POST['password'], PASSWORD_DEFAULT));
    $_POST['password'] = isset($_POST['password']) ? $_POST['password'] : "";
    $_POST['login'] = isset($_POST['login']) ? $_POST['login'] : "";
    if ($db->checkLogin($_POST['login'], $_POST['password'])) {

        $_SESSION['login'] = $_POST['login'];
        $_SESSION['password'] = $_POST['password'];
        require_once $_SERVER["DOCUMENT_ROOT"] . "/controller/DefaultController.php";
    } else {
        $erreur = "Mauvais login ou mot de passe";
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/login.php";
    }
}
