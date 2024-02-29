<?php 
$requestUri = $_SERVER['REQUEST_URI'];
$segments = explode('/', $requestUri);
$lastSegment = end($segments);
switch ($lastSegment) {
    case 'accueil':
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/accueil.php';
        break;
    case 'game':
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/game.php';
        break;
    default:
        require_once $_SERVER["DOCUMENT_ROOT"] . '/vue/accueil.php';
        break;
}

