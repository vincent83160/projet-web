<?php
require("../model/user.php");
session_start();

$requestUri = $_SERVER['REQUEST_URI'];
// Router les requêtes


// Vérifier si l'utilisateur est connecté 
$requestUri = filter_var(trim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL);
$segments = explode('/', $requestUri);
// Récupérer le dernier élément du tableau


$controller = $segments[0]  . "Controller";
if (isset($segments[1])) {
    $methode = $segments[1];
}

$nbSegments = count($segments);


if ($nbSegments >= 3) {
    $params = array();
    for ($i = 2; $i < $nbSegments; $i++) {
        $params[$segments[$i]] = $_POST[$segments[$i]];
    }
}

if (isset($_SESSION['login'])) {
    // Routes pour les utilisateurs connectés 
    var_dump($segments);
    // $controller = '/controller/' . $controller; 
    switch ($nbSegments) {
 

        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
        
        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
            $controller =  new $controller();
            $controller->$methode();

            break;
        case $nbSegments >= 3:
            
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
            $controller =  new $controller();
            $controller->$methode($params);
            break;
        // case 3:
        //     require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller .".php";
        //     $controller= new $controller();
        //     $controller->$methode($segments[2],$_POST[$segments[2]]);
        //     break;

        default:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            $controller =  new DefaultController();
            $controller->accueil();
            break;
    }
} else {
    switch ($nbSegments) {
        case 1:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
            break;
        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
            $controller =  new $controller();
            $controller->$methode();

            break;
        case 3:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
            $controller =  new $controller();
            $controller->$methode();
            break;

        default:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            $controller =  new DefaultController();
            $controller->accueil();
            break;
    }
}
