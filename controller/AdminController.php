<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/User.php';

class AdminController extends ConnexionMySql
{


    public function admin()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/admin.php";
    }

    public static function getConnexion()
    { 
        $db = new ConnexionMySql();
        $db->connexion();
        $pdo = $db->getPdo();
        
        return $pdo;  
    }


    public function gestion_user(){
        $db = User::createVide();
        $users = $db->getUsers();
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/gestion_user.php";
    }


    public static function createVide()
    {
        return new self(0, "", "", "", false, "");
    }
}
