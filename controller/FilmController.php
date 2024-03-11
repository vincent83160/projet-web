<?php
class FilmController{
    function films(){
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/film.php";
    }
}