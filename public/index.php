<?php

session_start();

$requestUri = $_SERVER['REQUEST_URI'];
// Router les requêtes


// Vérifier si l'utilisateur est connecté 
    $requestUri = $_SERVER['REQUEST_URI'];
    $segments = explode('/', $requestUri);
    // Récupérer le dernier élément du tableau
    $lastSegment = end($segments);
    // Vérifier si l'utilisateur est connecté 
    $beforeLastSegment = $segments[count($segments) - 2]; 
    
    if (isset($_SESSION['login'])) {
        echo $lastSegment;
         // Routes pour les utilisateurs connectés
        switch ($lastSegment) {
            
            case 'logout':
                require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DisconnectController.php';
                break;
            case 'userModif':
                require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/UserModifController.php';
                break;  
            case 'login':
                require_once $_SERVER["DOCUMENT_ROOT"] .    '/vue/login.php';
                break;
            case 'accueil':
                require_once $_SERVER["DOCUMENT_ROOT"] .    '/vue/accueil.php';
                break;
            default:
                require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
                break;
        }
    } else {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/login.php';
    }


