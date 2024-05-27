<?php

class GameController {

    function start() {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/controller/FilmController.php";
        $filmController = new FilmController(); 
        $filmController->checkIfFilmToFindToday();
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/game.php";
    }
  
}
