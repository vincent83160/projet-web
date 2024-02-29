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
    // Routes pour les utilisateurs connectés 
    switch ($beforeLastSegment) {
        case 'default':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            break;
        case '':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            break;
 
        default:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            break;
    }
} else {  
    switch ($lastSegment) {
        case '':
    require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            break;
        case 'login':
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/LoginController.php';
            break;
    }
}
