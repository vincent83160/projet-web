<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/User.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/Film.php';

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


    public function gestionUser()
    {
        if ($_SESSION["role"] == "ADMIN") {
            $db = User::createVide();
            $users = $db->getUsers();
            require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/gestion_user.php";
        } else {
            require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/erreur.php";
        }
    }
    public function gestionFilm()
    {
        if ($_SESSION["role"] == "ADMIN") {
            $db = Film::createVide();
            $films = $db->getFilms(); 
            foreach ($films as $key => $film) {
                $films[$key]["release_date"] = $this->formatDate($film["release_date"]);
            }
            require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/gestion_film.php";
        } else {
            require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/erreur.php";
        }
    }


    public function formatDate($date)
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            // Convertir la chaîne de caractères en objet DateTime
            $date = DateTime::createFromFormat('Y-m-d', $date);
        
            // Vérifier si la conversion a réussi
            if ($date !== false) {
                // Formater l'objet DateTime en DD/MM/YYYY
                $formatted_date = $date->format('d/m/Y');
                return $formatted_date;
            } 
        } 
        
    }
    public static function createVide()
    {
        return new self(0, "", "", "", false, "");
    }
}
