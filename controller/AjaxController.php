<?php
require $_SERVER["DOCUMENT_ROOT"] . "/controller/FilmController.php";
require $_SERVER["DOCUMENT_ROOT"] . "/controller/APIController.php";
require $_SERVER["DOCUMENT_ROOT"] . "/model/User.php";
class AjaxController
{
    function deleteByContext($params)
    {
        //urldecode permet de retrouver la string dans son état d'origine par exemple de remplacer les %20 par des espaces
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
    function addFilm($params)
    {
        //urldecode permet de retrouver la string dans son état d'origine par exemple de remplacer les %20 par des espaces        
        $idFilm = urldecode($params["idFilm"]);
        $apiController = new APIController();
        $apiController->getFilmById($idFilm);
    }



    function getFilmByTitre($params)
    {
        // urldecode permet de retrouver la string dans son état d'origine par exemple de remplacer les %20 par des espaces
        $titre = urldecode($params["query"]);
        $apiController = new APIController();
        $resultAPI = $apiController->getFilmsForGame($titre);
        $db = Film::createVide();
        $resultBDD = $db->getFilmByTitreLike($titre);
        $result = $this->mergeMovies($resultBDD, $resultAPI);
        echo json_encode($result);
    }

    //fonction qui permet de fusionner les films de la bdd et de l'api et de supprimmer les doublons
    function mergeMovies($moviesBDD, $moviedAPI)
    {
        $idMap = [];
        foreach ($moviesBDD as $movieBDD) {
            $idMap[$movieBDD["id"]] =  true;
        }
        foreach ($moviedAPI as $movieAPI) {
            if (!isset($idMap[$movieAPI->id])) {
                array_unshift($moviesBDD, $movieAPI);
            }
        }
        return $moviesBDD;
    }
    function checkIfFilmCorrect($params)
    {
        $filmController = new FilmController();
        $idFilm = $params["idFilm"];
        $apiController = new APIController();
        // Insert le film en bdd si il n'existe pas
        $apiController->getFilmById($idFilm);
        $db = Film::createVide();

        $filmChecked = $db->getFilmById($idFilm);

        $filmToFind = $db->getFilmToFind();
        $result = [];

        if ($idFilm == $filmToFind["id"]) {;
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

            foreach ($filmToFind["acteurs"] as $acteur) {
                $acteur = $db->getActeurByIdAndIdFilm($acteur, $filmToFind["id"]);
                $result["filmToFind"]["acteurs"][] = $acteur;
                $result["acteursCommunsDetails"][] = $acteur;
            }
            foreach ($filmToFind["realisateurs"] as $realisateur) {
                $realisateur = $db->getRealisateurByIdAndIdFilm($realisateur, $filmToFind["id"]);
                $result["filmToFind"]["realisateurs"][] = $realisateur;
                $result["realisateursCommunsDetails"][] = $realisateur;
            }

            foreach ($filmToFind["productions"] as $production) {
                $productions[] = $db->getProductionById($production);

            }
            $result["productionsCommuns"] = $productions;
            $result["filmToFind"]["productionsDetails"] = $productions;
            $result["filmChecked"] = $result["filmToFind"]; 
        } else {

            $result = $filmController->compare2Films($filmChecked, $filmToFind);
        }

        echo json_encode($result);
    }
}
