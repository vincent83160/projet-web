<?php

class GameController {
//fonction pour afficher la page de jeu
    function game() {
        if(!isset($_SESSION['user']) || $_SESSION['user'] == null) {
            header('Location: /login');
            
        }
        require_once $_SERVER["DOCUMENT_ROOT"] . "/controller/FilmController.php";
        $filmController = new FilmController(); 
        $filmController->checkIfFilmToFindToday();
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/game.php";
    }
  
}
