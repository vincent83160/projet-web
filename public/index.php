<?php
$requestUri = $_SERVER['REQUEST_URI'];
// Router les requêtes
session_start();

// Vérifier si l'utilisateur est connecté 

    $requestUri = $_SERVER['REQUEST_URI'];
    $segments = explode('/', $requestUri);
    // Récupérer le dernier élément du tableau
    $lastSegment = end($segments);
    // Vérifier si l'utilisateur est connecté 

    
    if (isset($_SESSION['login'])) {
        // Routes pour les utilisateurs connectés
        switch ($lastSegment) {
            case '':

                break;
            default:
                require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
                break;
        }
    } else {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/login.php';
    }
 
