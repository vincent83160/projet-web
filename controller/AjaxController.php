<?php
require $_SERVER["DOCUMENT_ROOT"] . "/controller/FilmController.php";
class AjaxController
{
    function getFilmByTitre($params)
    {
        //urldecode permet de retrouver la string dans son état d'origine par exemple de ermplacer les %20 par des espaces
        $titre = urldecode($params["query"]);
        $db = Film::createVide();
        $result = $db->getFilmByTitreLike($titre);
        echo json_encode($result);
    }


    function checkIfFilmCorrect($params)
    {
        $filmController = new FilmController();
        $idFilm = $params["idFilm"];
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
