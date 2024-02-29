<?php

class UserController
{


    public function membre()
    {
        

        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/membre.php";
    }

    public function userModif($input, $value)
    {
        //require("../model/user.php");
        $_SESSION['user']->__set($input, $value);
        // var_dump($_SESSION['user']);
        // var_dump($_POST);
        // echo $input;
        // echo "</br>";
        // echo $value;
        header('Location: /User/membre');

    }
    
    public function logout()
    {
        //session_start();
        session_destroy();
        header("location: /Default/accueil");
    }

    public function login()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/model/User.php';
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
        $db = new ConnexionMySql();
        $erreur = "";
        if (isset($_SESSION['login']) && isset($_SESSION['password'])) {

            header("location: /Default/accueil");
        } else {
            $_POST['password'] = isset($_POST['password']) ? $_POST['password'] : "";
            $_POST['login'] = isset($_POST['login']) ? $_POST['login'] : "";

            $result = $db->checkLogin($_POST['login'], $_POST['password']);
            if ($result) {
                $user = new User($result["id"], $result["email"], $result["pseudo"], $result["password"], $result["is_verified"], $result["role"]);
                $_SESSION['user'] = $user;
                $_SESSION['login'] = $result['pseudo'];

                require($_SERVER["DOCUMENT_ROOT"] . "/vue/game.php");
            } else {
                $erreur = "Mauvais login ou mot de passe";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/login.php";
            }
        }
    }
}
