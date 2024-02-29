<?php
require_once("../model/user.php");
require_once $_SERVER["DOCUMENT_ROOT"].'/model/ConnexionMySql.php';
$db = new ConnexionMySql();
$erreur = ""; 
session_start();
if (isset($_SESSION['login']) && isset($_SESSION['password'])) {

    require($_SERVER["DOCUMENT_ROOT"]."/vue/jeu.php");
} else { 
    // var_dump(password_hash($_POST['password'], PASSWORD_DEFAULT));
    $result=$db->checkLogin($_POST['login'], $_POST['password']);
    if ($result) {
        $user= new User($result["id"],$result["email"],$result["pseudo"],$result["password"],$result["is_verified"],$result["role"]);
        $_SESSION['user'] = $user;
        require($_SERVER["DOCUMENT_ROOT"]."/vue/jeu.php");
    } else {
        $erreur = "Mauvais login ou mot de passe";
        header("Location: /login.php");
    }
 
}
