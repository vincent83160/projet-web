<?php
// Inclusion des fichiers requis
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/User.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/Film.php';

// Déclaration de la classe AdminController qui étend ConnexionMySql
class AdminController
{
    // Méthode pour afficher la page d'administration
    public function admin()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/admin.php";
    }

    // Méthode pour gérer les utilisateurs
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

    // Méthode pour gérer les films
    public function gestionFilm()
    {
        if ($_SESSION["role"] == "ADMIN") {
            $db = Film::createVide();
            $films = $db->getFilms();
            // Formater les dates des films
            foreach ($films as $key => $film) {
                $films[$key]["release_date"] = $this->formatDate($film["release_date"]);
            }
            require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/gestion_film.php";
        } else {
            require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/erreur.php";
        }
    }

    // Méthode pour formater les dates
    public function formatDate($date)
    {
        if (preg_match('/^\\d{4}-\\d{2}-\\d{2}$/', $date)) {
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

    // Méthode statique pour créer une instance vide de AdminController
    public static function createVide()
    {
        return new self(0, "", "", "", false, "");
    }
}
?>
