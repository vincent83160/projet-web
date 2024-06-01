<?php

class DefaultController
{
    // Méthode pour afficher la page d'accueil
    public function accueil()
    {
       
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/accueil.php';
    }
 
}
