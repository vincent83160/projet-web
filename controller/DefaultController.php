<?php 
$requestUri = $_SERVER['REQUEST_URI'];
$segments = explode('/', $requestUri);
$lastSegment = end($segments);
switch ($lastSegment) {
    case 'accueil':
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/accueil.php';
        break;
    case 'jeu':
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/jeu.php';
        break;
    default:
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/accueil.php';
        break;
}

