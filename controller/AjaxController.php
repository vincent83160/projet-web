<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . "/model/film.php";
    class AjaxController{
        function getFilmByTitle(){
            
            $db= film::createVide() ;
            $films=$db->geFilmByTitle($_POST["query"]) ;
            //echo $_POST["query"];
            //var_dump($films);
            echo json_encode($films);
        }
    }