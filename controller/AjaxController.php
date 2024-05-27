<?php
require $_SERVER["DOCUMENT_ROOT"] . "/controller/FilmController.php";
require $_SERVER["DOCUMENT_ROOT"] . "/controller/APIController.php";
class AjaxController
{
    function getFilmByTitre($params)
    {
        //urldecode permet de retrouver la string dans son état d'origine par exemple de remplacer les %20 par des espaces
        $titre = urldecode($params["query"]);
        $apiController = new APIController();
        $resultAPI = $apiController->getFilmsForGame($titre);
        $db = Film::createVide();
        $resultBDD = $db->getFilmByTitreLike($titre);
        $result = array_merge($resultAPI, $resultBDD);
        echo json_encode($result);
    }


    function checkIfFilmCorrect($params)
    {
        $filmController = new FilmController();
        $idFilm = $params["idFilm"];
        $apiController = new APIController();
        //Insert le film en bdd si il n'existe pas
        $result = $apiController->getFilmById($idFilm);
 
        $db = Film::createVide();

        $filmToFind = $db->getFilmToFind();



        if ($idFilm == $filmToFind["id"]) {
            $result = $filmToFind;
            $result["isCorrect"] = true;
            $result["acteurs"] = [];
            foreach ($filmToFind["acteurs"] as $acteur) {
                $result["acteurs"][] = $db->getActeurByIdAndIdFilm($acteur, $filmToFind["id"]);
            }
        } else {


            $filmChecked = $db->getFilmById($idFilm);

            $result = $filmController->compare2Films($filmChecked, $filmToFind);
        }
        // var_dump($comparaison);
        echo json_encode($result);
    }
}
