<?php

session_start();

$requestUri = $_SERVER['REQUEST_URI'];
// Router les requêtes


// Vérifier si l'utilisateur est connecté 
$requestUri = $_SERVER['REQUEST_URI'];
$segments = explode('/', $requestUri);
// Récupérer le dernier élément du tableau
unset($segments[0]);
$controller =$segments[1]."Controller"  ;
if(isset($segments[2])){
    $methode = $segments[2];
}
  
$nbSegments = count($segments);
// Vérifier si l'utilisateur est connecté   
if ($segments[1] == "") {
    $nbSegments = 0;
}

if (isset($_SESSION['login'])) {
    // Routes pour les utilisateurs connectés 
    // $controller = '/controller/' . $controller;
    switch ($nbSegments) {
        case 1:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            break;
        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            $controller =  new $controller();
            $controller->$methode();

            break;
        case 3:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            break;

        default:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            break;
    }
} else { 
    switch ($nbSegments) {
        case 1:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            break;
        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php"; 
            $controller =  new $controller();
            $controller->$methode();

            break;
        case 3:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            break;

        default:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/UserController.php';
            $controller =  new UserController();
            $controller->login();
            break;
 
    }
}




    // if (isset($_SESSION['login'])) {
    //     echo $lastSegment;
    //      // Routes pour les utilisateurs connectés
    //     switch ($lastSegment) {
            
    //         case 'logout':
    //             require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DisconnectController.php';
    //             break;
    //         case 'userModif':
    //             require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/UserModif.php';
    //             break;  
    //         case 'login':
    //             require_once $_SERVER["DOCUMENT_ROOT"] .    '/vue/login.php';
    //             break;
    //         case 'accueil':
    //             require_once $_SERVER["DOCUMENT_ROOT"] .    '/vue/accueil.php';
    //             break;
    //         default:
    //             require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
    //             break;
    //     }
    // } else {
    //     require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/login.php';
    // }
