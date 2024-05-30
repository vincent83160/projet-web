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

        $result = $db->getFilmById($idFilm);

        $filmToFind = $db->getFilmToFind();


        if ($idFilm == $filmToFind["id"]) {
            $result = $filmToFind;
            $result["isCorrect"] = true;
            $result["acteurs"] = [];
            $result["realisateurs"] = [];

            foreach ($filmToFind["acteurs"] as $acteur) {
                $result["acteurs"][] = $db->getActeurByIdAndIdFilm($acteur, $filmToFind["id"]);
            }
            foreach ($filmToFind["realisateurs"] as $realisateur) {
                $result["realisateurs"][] = $db->getRealisateurByIdAndIdFilm($realisateur, $filmToFind["id"]);
            }
        } else {

            $result = $filmController->compare2Films($result, $filmToFind);
        }

        echo json_encode($result);
    }
}
