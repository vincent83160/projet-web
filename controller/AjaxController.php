<?php
// Inclusion des contrôleurs et modèles nécessaires
require $_SERVER["DOCUMENT_ROOT"] . "/controller/FilmController.php";
require $_SERVER["DOCUMENT_ROOT"] . "/controller/APIController.php";
require $_SERVER["DOCUMENT_ROOT"] . "/model/User.php";

// Déclaration de la classe AjaxController
class AjaxController
{
    // Méthode pour supprimer un élément selon le contexte
    function deleteByContext($params)
    {
        if ($_SESSION["role"] == "ADMIN") {
        // Décodage de l'URL pour obtenir les valeurs originales
        $context = urldecode($params["context"]);
        $idElem = urldecode($params["idElem"]);

        if ($context == "film") {
            $db = Film::createVide();
            $db->deleteFilmByID($idElem);
        } elseif ($context == "user") {
            $db = User::createVide();
            $db->deleteUserByID($idElem);
        }
    }
    }

    // Méthode pour ajouter un film en utilisant l'API
    function addFilm($params)
    {
        // Décodage de l'URL pour obtenir les valeurs originales
        $idFilm = urldecode($params["idFilm"]);
        $apiController = new APIController();
        $apiController->getFilmById($idFilm);
    }

    // Méthode pour obtenir un film par son titre
    function getFilmByTitre($params)
    {
        // Décodage de l'URL pour obtenir les valeurs originales
        $titre = urldecode($params["query"]);
        $apiController = new APIController();
        $resultAPI = $apiController->getFilmsForGame($titre);
        $db = Film::createVide();
        $resultBDD = $db->getFilmByTitreLike($titre);
        $result = $this->mergeMovies($resultBDD, $resultAPI);
        echo json_encode($result);
    }

    // Fonction pour fusionner les films de la base de données et de l'API, et supprimer les doublons
    function mergeMovies($moviesBDD, $moviesAPI)
    {
        $idMap = [];
        foreach ($moviesBDD as $movieBDD) {
            $idMap[$movieBDD["id"]] = true;
        }
        foreach ($moviesAPI as $movieAPI) {
            if (!isset($idMap[$movieAPI->id])) {
                $moviesBDD[] = $movieAPI;
            }
        }
        return $moviesBDD;
    }

    // Méthode pour vérifier si un film est correct
    function checkIfFilmCorrect($params)
    {
        $filmController = new FilmController();
        $idFilm = $params["idFilm"];
        $apiController = new APIController();
        // Insère le film en BDD s'il n'existe pas
        $apiController->getFilmById($idFilm);
        $db = Film::createVide();

        $filmChecked = $db->getFilmById($idFilm);
        $filmToFind = $db->getFilmToFind();
        $result = [];

        if ($idFilm == $filmToFind["id"]) {
            // Initialiser les champs nécessaires pour la comparaison
            $result["filmToFind"] = $filmToFind;
            $result["filmChecked"] = $filmChecked;
            $result["filmToFind"]["acteurs"] = [];
            $result["filmChecked"]["acteurs"] = [];
            $result["filmToFind"]["realisateurs"] = [];
            $result["filmChecked"]["realisateurs"] = [];
            $result["isCorrect"] = true;
            $result["genresCommuns"] = $filmChecked["genres"];
            $result["genresNonCommuns"] = [];
            $result["paysCommuns"] = $filmChecked["pays"];
            $result["paysNonCommuns"] = [];
            $result["productionsCommuns"] = $filmChecked["productions"];
            $result["productionsNonCommuns"] = [];
            $result["acteursCommuns"] = $filmChecked["acteurs"];
            $result["acteursNonCommuns"] = [];
            $result["realisateursCommuns"] = $filmChecked["realisateurs"];
            $result["realisateursNonCommuns"] = [];

            // Comparaison des acteurs
            foreach ($filmToFind["acteurs"] as $acteur) {
                $acteur = $db->getActeurByIdAndIdFilm($acteur, $filmToFind["id"]);
                $result["filmToFind"]["acteurs"][] = $acteur;
                $result["acteursCommunsDetails"][] = $acteur;
            }

            // Comparaison des réalisateurs
            foreach ($filmToFind["realisateurs"] as $realisateur) {
                $realisateur = $db->getRealisateurByIdAndIdFilm($realisateur, $filmToFind["id"]);
                $result["filmToFind"]["realisateurs"][] = $realisateur;
                $result["realisateursCommunsDetails"][] = $realisateur;
            }

            // Comparaison des productions
            $productions = [];
            foreach ($filmToFind["productions"] as $production) {
                $productions[] = $db->getProductionById($production);
            }
            $result["productionsCommuns"] = $productions;
            $result["filmToFind"]["productionsDetails"] = $productions;
            $result["filmChecked"] = $result["filmToFind"];
        } else {
            // Comparer les deux films si les ID ne correspondent pas
            $result = $filmController->compare2Films($filmChecked, $filmToFind);
        }

        echo json_encode($result);
    }
}
?>
