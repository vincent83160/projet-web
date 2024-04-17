<?php
require $_SERVER["DOCUMENT_ROOT"] . "/model/film.php";
require $_SERVER["DOCUMENT_ROOT"] . "/controller/FilmController.php";
class AjaxController
{
    function getFilmByTitre($params)
    {
        $titre = $params["query"];
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
        


    
        if ($idFilm== $filmToFind["id_film"]) {
            $result["isCorrect"] = true;
        } else {
            $filmChecked = $db->getFilmById($idFilm);
            $result = $filmController->compare2Films($filmChecked, $filmToFind);
        }
        // var_dump($comparaison);
        echo json_encode($result);
    }
}
