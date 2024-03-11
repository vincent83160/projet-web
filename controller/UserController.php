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
            $value = $value;

            $_SESSION['user']->__set($input, $value);

            // var_dump($_SESSION['user']);
            // var_dump($_POST);

            require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
            $db = new ConnexionMySql();
            $db->connexion();
            $pdo = $db->getPdo();
            $id = $_SESSION['user']->getId();

            $req = "UPDATE user SET " . $input . " = :value"; //WHERE id = :id";
            $stmt = $pdo->prepare($req);
            //$stmt->bindParam(':input', $input, PDO::PARAM_STR);
            $stmt->bindParam(':value', $value);
            //$stmt->bindParam(':id',$id );     
            $stmt->debugDumpParams();
            $stmt->execute();
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
        require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
        $db = new ConnexionMySql();
        $db->connexion();
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
