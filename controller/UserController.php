<?php

class UserController
{


    public function membre()
    {


        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/membre.php";
    }

    public function userModif($params)
    {
        //require("../model/user.php")
        foreach ($params as $key => $value) {
            $input = $key;

            $_SESSION['user']->__set($input, $value);

            // var_dump($_SESSION['user']);
            // var_dump($_POST);

            $db =  user::createVide();
            
            $db->update($input, $value, $_SESSION['user']->getId()); 

   
        }


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
        require_once $_SERVER["DOCUMENT_ROOT"] . '/model/user.php';
        $db =  user::createVide();
        
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

    public function signIn(){
        require_once $_SERVER["DOCUMENT_ROOT"] . '/model/User.php';
        if(isset($_POST['mail'])){
            $db =  user::createVide();
            $db->create($_POST['mail'], $_POST['pseudo'], $_POST['password'], 0, 'USER');
            header("location: /Vue/signInConfirm");
            //var_dump($_POST);
        }
        else{
            require_once  $_SERVER["DOCUMENT_ROOT"] . "/vue/signIn.php";
        }
        
    }
}
