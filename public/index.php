<?php
require("../model/user.php"); 
session_start();

$requestUri = $_SERVER['REQUEST_URI'];
// Router les requêtes


// Vérifier si l'utilisateur est connecté 
$requestUri = trim($_SERVER['REQUEST_URI'],'/');
$segments = explode('/', $requestUri);
// Récupérer le dernier élément du tableau


$controller =$segments[0]."Controller"  ;
if(isset($segments[1])){
    $methode = $segments[1];
}
  
$nbSegments = count($segments);
// Vérifier si l'utilisateur est connecté   


if (isset($_SESSION['login'])) {
    // Routes pour les utilisateurs connectés 
    // $controller = '/controller/' . $controller; 
    switch ($nbSegments-1) {

        
        case 1:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            $controller =  new $controller();
            $controller->$methode();

            break;
        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            break;

        default:

            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            $controller =  new DefaultController();
            $controller->accueil();
            break;
    }
} else { 
    switch ($nbSegments) {
        case 0:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            break;
        case 1:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php"; 
            $controller =  new $controller();
            $controller->$methode();

            break;
        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            $controller =  new $controller();
            $controller->$methode();
            break;

        default:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/UserController.php';
            $controller =  new UserController();
            $controller->login();
            break;
 
    }
}

