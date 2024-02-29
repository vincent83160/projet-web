<?php

class UserController
{


    public function membre()
    {



        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/membre.php";
    }

    public function userModif()
    {
        require("../model/user.php");


        switch ($_POST['input']) {
            case 'email':
                $_SESSION['user']->setEmail($_POST['email']);
                header('Location: ../model/membre.php?mail');
                break;
            case 'pwd':
                $_SESSION['user']->setPassword($_POST['pwd']);
                header('Location: ../model/membre.php?pwd');
                break;
            case 'pseudo':
                $_SESSION['user']->setPseudo($_POST['pseudo']);
                header('Location: ../model/membre.php?pseudo');
                break;
            case 'isVerified':
                $_SESSION['user']->setIsVerified($_POST['isVerified']);
                header('Location: ../model/membre.php?isv');
                break;
            case 'role':
                $_SESSION['user']->setRole($_POST['role']);
                header('Location: ../model/membre.php?role  ');
                break;
        }
    
    }
    public function logout()
    {
        session_start();
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
