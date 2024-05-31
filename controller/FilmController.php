<?php

require $_SERVER["DOCUMENT_ROOT"] . "/model/Film.php";
require $_SERVER["DOCUMENT_ROOT"] . "/model/Historique_film.php";

class FilmController
{
    function films()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/film.php";
    }


    function checkIfFilmToFindToday()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/model/Film.php";
        $db = Historique_film::createVide();
        $db->checkIfFilmToFindToday();
    }


    function compare2Films($filmChecked, $filmToFind) {
        $db = Film::createVide();
        $acteursCommuns = [];
        $acteursNonCommuns = [];
        $acteursCommunsDetails = [];
        $acteursNonCommunsDetails = [];
        $realisateursFilmChecked = [];
    
        $acteursFilmChecked = [];
        $acteurs = [];
    
        $realisateursCommuns = [];
        $realisateursNonCommuns = [];
        $realisateursCommunsDetails = [];
        $realisateursNonCommunsDetails = [];
        $realisateurs = [];
    
        $genresCommuns = [];
        $genresNonCommuns = [];
    
        $paysCommuns = [];
        $paysNonCommuns = [];
    
        $productionsCommuns = [];
        $productionsNonCommuns = []; 
    
        $productionsCommunsDetails = [];
        $productionsNonCommunsDetails = []; 
        $productionsFilmChecked = [];
    
        $acteursCommuns = array_intersect($filmChecked["acteurs"], $filmToFind["acteurs"]);
        $acteursNonCommuns = array_diff($filmChecked["acteurs"], $filmToFind["acteurs"]);
      
        $realisateursCommuns = array_intersect($filmChecked["realisateurs"], $filmToFind["realisateurs"]);
        $realisateursNonCommuns = array_diff($filmChecked["realisateurs"], $filmToFind["realisateurs"]);
    
        foreach ($filmChecked["acteurs"] as $acteur) {
            $acteursFilmChecked[] = $db->getActeurByIdAndIdFilm($acteur, $filmChecked["id"]);
        }
        foreach ($acteursCommuns as $acteur) {
            $acteursCommunsDetails[] = $db->getActeurByIdAndIdFilm($acteur, $filmToFind["id"]);
        }
    
        foreach ($acteursNonCommuns as $acteur) {
            $acteursNonCommunsDetails[] = $db->getActeurByIdAndIdFilm($acteur, $filmChecked["id"]);
        }
    
        foreach ($filmChecked["realisateurs"] as $real) {
            $realisateursFilmChecked[] = $db->getRealisateurByIdAndIdFilm($real, $filmChecked["id"]);
        }
    
        foreach ($realisateursCommuns as $real) {
            $realisateursCommunsDetails[] = $db->getRealisateurByIdAndIdFilm($real, $filmToFind["id"]);
        }
    
        foreach ($realisateursNonCommuns as $real) {
            $realisateursNonCommunsDetails[] = $db->getRealisateurByIdAndIdFilm($real, $filmChecked["id"]);
        }
    
        $genresCommuns = array_intersect($filmChecked["genres"], $filmToFind["genres"]);
        $genresNonCommuns = array_diff($filmChecked["genres"], $filmToFind["genres"]);
    
        $paysCommuns = array_intersect($filmChecked["pays"], $filmToFind["pays"]);
        $paysNonCommuns = array_diff($filmChecked["pays"], $filmToFind["pays"]);
    
        $productionsCommuns = array_intersect($filmChecked["productions"], $filmToFind["productions"]);
        $productionsNonCommuns = array_diff($filmChecked["productions"], $filmToFind["productions"]);
    
        foreach ($filmChecked["productions"] as $production) {
            $productionsFilmChecked[] = $db->getProductionById($production);
        }
        foreach ($productionsCommuns as $production) {
            $productionsCommunsDetails[] = $db->getProductionById($production);
        }
    
        foreach ($productionsNonCommuns as $production) {
            $productionsNonCommunsDetails[] = $db->getProductionById($production);
        }
    
        foreach ($filmChecked["realisateurs"] as $realisateur) {
            $realisateurs[] = $db->getRealisateurByIdAndIdFilm($realisateur, $filmChecked["id"]);
        }
    
        $result = [
            "acteursCommunsDetails" => $acteursCommunsDetails,
            "acteursNonCommunsDetails" => $acteursNonCommunsDetails,
            "acteurs" => $acteurs, 
            "realisateursFilmChecked" => $realisateursFilmChecked, 
            "realisateurs" => $realisateurs,
            "realisateursCommunsDetails" => $realisateursCommunsDetails,
            "realisateursNonCommunsDetails" => $realisateursNonCommunsDetails,
            "realisateurs" => $realisateurs,
            "genresCommuns" => array_values($genresCommuns),
            "genresNonCommuns" => array_values($genresNonCommuns),
            "paysCommuns" => array_values($paysCommuns),
            "paysNonCommuns" => array_values($paysNonCommuns),
            "productionsCommuns" => array_values($productionsCommunsDetails),
            "productionsNonCommuns" => array_values($productionsNonCommunsDetails),
            "productionsFilmChecked" => array_values($productionsFilmChecked),
            "filmChecked" => $filmChecked,
            "filmToFind" => $filmToFind
        ];
    
        return $result;
    }
    
}
