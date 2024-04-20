<?php

require $_SERVER["DOCUMENT_ROOT"] . "/model/film.php";

class FilmController
{
    function films()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/film.php";
    }


    function compare2Films($filmChecked, $filmToFind)
    {

        $db = Film::createVide();
        $acteursCommuns = [];
        $acteursNonCommuns = [];
        $acteursCommunsDetails = [];
        $acteursNonCommunsDetails = [];

        $realisateursCommuns = [];
        $realisateursNonCommuns = [];
        $realisateursCommunsDetails = [];
        $realisateursNonCommunsDetails = [];


        $genresCommuns = [];
        $genresNonCommuns = [];


        $acteursCommuns = array_intersect($filmChecked["acteurs"], $filmToFind["acteurs"]);
        $acteursNonCommuns = array_diff($filmChecked["acteurs"], $filmToFind["acteurs"]);


        $realisateursCommuns = array_intersect($filmToFind["realisateurs"], $filmToFind["realisateurs"]);
        $realisateursNonCommuns = array_diff($filmChecked["realisateurs"], $filmToFind["realisateurs"]);


        foreach ($acteursCommuns as $acteur) {
            $acteursCommunsDetails[] = $db->getActeurById($acteur);
        }

        foreach ($acteursNonCommuns as $acteur) {
            $acteursNonCommunsDetails[] = $db->getActeurById($acteur);
        }
        foreach ($realisateursCommuns as $real) {
            $realisateursCommunsDetails[] = $db->getActeurById($real);
        }

        foreach ($realisateursNonCommuns as $real) {
            $realisateursNonCommunsDetails[] = $db->getRealisateurById($real);
        }

        $genresCommuns = array_intersect($filmToFind["genres"], $filmChecked["genres"]);
        $genresNonCommuns = array_diff($filmToFind["genres"], $filmChecked["genres"]);

        $result = [
            "acteursCommunsDetails" => $acteursCommunsDetails,
            "acteursNonCommunsDetails" => $acteursNonCommunsDetails,
            "realisateursCommunsDetails" => $realisateursCommunsDetails,
            "realisateursNonCommunsDetails" => $realisateursNonCommunsDetails,
            "genresCommuns" => $genresCommuns,
            "genresNonCommuns" => $genresNonCommuns,
            "filmChecked" => $filmChecked,
            "filmToFind" => $filmToFind

        ];
        return $result;
    }
}
