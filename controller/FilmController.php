<?php

require $_SERVER["DOCUMENT_ROOT"] . "/model/film.php";
require $_SERVER["DOCUMENT_ROOT"] . "/model/historique_film.php";

class FilmController
{
    function films()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/film.php";
    }


    function checkIfFilmToFindToday(){
        require_once $_SERVER["DOCUMENT_ROOT"] . "/model/film.php"; 
        $db = Historique_film::createVide();
        $db->checkIfFilmToFindToday();    
    }


    function compare2Films($filmChecked, $filmToFind)
    {

        $db = Film::createVide();
        $acteursCommuns = [];
        $acteursNonCommuns = [];
        $acteursCommunsDetails = [];
        $acteursNonCommunsDetails = [];
        $acteurs = [];


        $realisateursCommuns = [];
        $realisateursNonCommuns = [];
        $realisateursCommunsDetails = [];
        $realisateursNonCommunsDetails = [];
        $realisateurs = [];


        $genresCommuns = [];
        $genresNonCommuns = [];


        $acteursCommuns = array_intersect($filmChecked["acteurs"], $filmToFind["acteurs"]);
        $acteursNonCommuns = array_diff($filmChecked["acteurs"], $filmToFind["acteurs"]);


        $realisateursCommuns = array_intersect($filmToFind["realisateurs"], $filmToFind["realisateurs"]);
        $realisateursNonCommuns = array_diff($filmChecked["realisateurs"], $filmToFind["realisateurs"]);


        foreach ($acteursCommuns as $acteur) {
            $acteursCommunsDetails[] = $db->getActeurByIdAndIdFilm($acteur, $filmToFind["id"]);
        }

        foreach ($acteursNonCommuns as $acteur) {
            $acteursNonCommunsDetails[] = $db->getActeurByIdAndIdFilm($acteur, $filmToFind["id"]);
        }
        foreach ($realisateursCommuns as $real) {
            $realisateursCommunsDetails[] = $db->getRealisateurByIdAndIdFilm($real, $filmToFind["id"]);
        }

        foreach ($realisateursNonCommuns as $real) {
            $realisateursNonCommunsDetails[] = $db->getRealisateurByIdAndIdFilm($real, $filmToFind["id"]);
        }

        $genresCommuns = array_intersect($filmToFind["genres"], $filmChecked["genres"]);
        $genresNonCommuns = array_diff($filmToFind["genres"], $filmChecked["genres"]);

        foreach ($filmChecked["acteurs"] as $acteur) {
            $acteurs[] = $db->getActeurByIdAndIdFilm($acteur, $filmChecked["id"]);
        }
        foreach ($filmChecked["realisateurs"] as $realisateur) {
            $realisateurs[] = $db->getRealisateurByIdAndIdFilm($realisateur, $filmChecked["id"]);
        }


        $result = [
            "acteursCommunsDetails" => $acteursCommunsDetails,
            "acteursNonCommunsDetails" => $acteursNonCommunsDetails,
            "acteurs" => $acteurs,
            "realisateursCommunsDetails" => $realisateursCommunsDetails,
            "realisateursNonCommunsDetails" => $realisateursNonCommunsDetails,
            "realisateurs" => $realisateurs,

            "genresCommuns" => $genresCommuns,
            "genresNonCommuns" => $genresNonCommuns,

            "filmChecked" => $filmChecked,
            "filmToFind" => $filmToFind

        ];
        return $result;
    }
}
