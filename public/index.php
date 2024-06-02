<?php
session_start();
$requestUri = $_SERVER['REQUEST_URI'];
// Router les requêtes


// Vérifier si l'utilisateur est connecté 
$requestUri = filter_var(trim($_SERVER['REQUEST_URI'], '/'), FILTER_SANITIZE_URL);
$segments = explode('/', $requestUri);
// Récupérer le dernier élément du tableau
$segments[0] = ucfirst($segments[0]);
$controller = $segments[0]  . "Controller";
if (isset($segments[1])) {
    $methode = $segments[1];
}

$nbSegments = count($segments);

if ($nbSegments >= 3) {
    $params = array();
    for ($i = 2; $i < $nbSegments; $i++) {
        $param = explode("=", $segments[$i]);
        $params[$param[0]] = $param[1];
    }
} else if (isset($_POST) && $_POST != null) {
    $params = $_POST;
    $nbSegments++;
}

 
if ($segments[0] == "" || count($segments) == 0 ) {
    $controller = "DefaultController";
    $methode = "accueil";
}  
if (isset($_SESSION['pseudo'])) {
    if (!file_exists($_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php")) {
        header("Location: /default/accueil");
        exit;
    }


    switch ($nbSegments) {


        case 1:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";

        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
            $controller =  new $controller();

            if (method_exists($controller, $methode)) {
                $controller->$methode();
            } else {
                // Rediriger vers l'accueil si la méthode n'existe pas
                header("Location: /default/accueil");
            }

            break;
        case $nbSegments >= 3:

            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
            $controller =  new $controller();
            if (method_exists($controller, $methode)) {
                $controller->$methode($params);
            } else {
                // Rediriger vers l'accueil si la méthode n'existe pas
                header("Location: /default/accueil");
            }
            break;


        default:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/DefaultController.php';
            $controller =  new DefaultController();
            $controller->accueil();
            break;
    }
} else { 
    if (!file_exists($_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php")) {
        header("Location: /default/accueil");
        exit;
    }

    switch ($nbSegments) {
        default:
        case 1:
            header("Location: /default/accueil");
            break;
        case 2:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
            $controller =  new $controller();
            if (method_exists($controller, $methode)) {
                $controller->$methode();
            } else {
                // Rediriger vers l'accueil si la méthode n'existe pas
                header("Location: /default/accueil");
            }

            break;
        case 3:
            require_once $_SERVER["DOCUMENT_ROOT"] . '/controller/' . $controller . ".php";
            $controller =  new $controller();
            if (method_exists($controller, $methode)) {
                $controller->$methode($params);
            } else {
                // Rediriger vers l'accueil si la méthode n'existe pas
                header("Location: /default/accueil");
            }
            break;
    }
}
