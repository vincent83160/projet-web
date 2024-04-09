<?php
require $_SERVER["DOCUMENT_ROOT"] . "/model/film.php";
    class AjaxController{
        function getFilmByTitre($params){
            $titre = $params["query"];
            $db = Film::createVide();
            $result = $db->getFilmByTitreLike($titre);
            echo json_encode($result);
        }
    }