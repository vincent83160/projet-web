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


    function compare2Films($filmChecked, $filmToFind)
    {

        $db = Film::createVide();
        $acteursCommuns = [];
        $acteursNonCommuns = [];
        $acteursCommunsDetails = [];
        $acteursNonCommunsDetails = [];
        $realisateursFilmChecked = [];
 
        $acteurs = [];


        $realisateursCommuns = []; 
        $realisateursCommunsDetails = []; 
        $realisateurs = [];


        $genresCommuns = [];
        $genresNonCommuns = [];


        $acteursCommuns = array_intersect($filmChecked["acteurs"], $filmToFind["acteurs"]);
        $acteursNonCommuns = array_diff($filmChecked["acteurs"], $filmToFind["acteurs"]);


        $realisateursCommuns = array_intersect($filmChecked["realisateurs"],$filmToFind["realisateurs"]);
        $realisateursNonCommunsLength = count(array_diff($filmChecked["realisateurs"], $filmToFind["realisateurs"]));


 
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

   
        $genresCommuns = array_intersect($filmChecked["genres"],$filmToFind["genres"]);
        $genresNonCommuns = array_diff($filmChecked["genres"],$filmToFind["genres"]);

        foreach ($filmToFind["acteurs"] as $acteur) {
            $acteurs[] = $db->getActeurByIdAndIdFilm($acteur, $filmToFind["id"]);
        }

        foreach ($filmChecked["realisateurs"] as $realisateur) {
            $realisateurs[] = $db->getRealisateurByIdAndIdFilm($realisateur, $filmChecked["id"]);
        }


        $result = [
            "acteursCommunsDetails" => $acteursCommunsDetails,
            "acteursNonCommunsDetails" => $acteursNonCommunsDetails,
            "acteurs" => $acteurs, 
            "realisateursFilmChecked" => $realisateursFilmChecked,
            "realisateursNonCommunsLength" => $realisateursNonCommunsLength, 
            "realisateurs" => $realisateurs,
            "realisateursCommunsDetails" => $realisateursCommunsDetails,

            // "genresFilmToFind" => $filmToFind["genres"],
            // "genresFilmChecked" => $filmChecked["genres"],
            "genresCommuns" => $genresCommuns,
            "genresNonCommuns" => $genresNonCommuns,

            "filmChecked" => $filmChecked,
            "filmToFind" => $filmToFind

        ];
        return $result;
    }
}
