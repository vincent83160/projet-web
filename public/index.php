<?php
$requestUri = $_SERVER['REQUEST_URI'];
var_dump($requestUri);
// Router les requêtes
switch ($requestUri) {
    case '/':
        // Afficher la page d'accueiln
        require_once 'acceuil.php';
        break;
    case '/login':
        // Afficher la page "À propos"
        require_once 'login.php';
        break;
        // Ajouter d'autres routes au besoin
    default:
        // Afficher une page d'erreur 404
        header("HTTP/1.0 404 Not Found");
        echo 'Page not found';
        break;
}
