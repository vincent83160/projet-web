<?php

class DefaultController
{
    public function accueil()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/Accueil.php';
    }
    public function game()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/Game.php';
    }
}
