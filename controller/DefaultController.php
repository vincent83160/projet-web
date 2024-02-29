<?php



class DefaultController
{
    public function accueil()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/accueil.php';
    }
    public function game()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/game.php';
    }
}
