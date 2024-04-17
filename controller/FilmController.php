<?php
class FilmController
{
    function films()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/film.php";
    }


    function compare2Films($filmChecked, $filmToFind)
    {
        // var_dump($filmChecked["acteurs"]); 
        $acteursCommuns = [];
        $realisateursCommuns = [];
        $genresCommuns = [];
        foreach ($filmChecked["acteurs"] as $acteur) {
            if (($key = array_search($acteur, $filmToFind["acteurs"])) !== false) {
                unset($filmToFind["acteurs"][$key]);
                unset($filmChecked["acteurs"][$key]);
                $acteursCommuns[] = $acteur;
            }
        }

        foreach ($filmChecked["realisateurs"] as $realisateur) {
            if (($key = array_search($realisateur, $filmToFind["realisateurs"])) !== false) {
                unset($filmToFind["realisateurs"][$key]);
                unset($filmChecked["realisateurs"][$key]);
                $realisateursCommuns[] = $realisateur;
            }
        }

        foreach ($filmChecked["genres"] as $genre) {
            if (($key = array_search($genre, $filmToFind["genres"])) !== false) {
                unset($filmToFind["genres"][$key]);
                unset($filmChecked["genres"][$key]);
                $genresCommuns[] = $genre;
            }
        }

        // var_dump(array_intersect($filmChecked["acteurs"], $filmToFind["acteurs"]));
        // $realisateursCommuns = array_intersect($filmChecked["realisateurs"], $filmToFind["realisateurs"]);
        // $genresCommuns = array_intersect($filmChecked["genres"], $filmToFind["genres"]);
        $result = [
            "acteursCommuns" => $acteursCommuns,
            "realisateursCommuns" => $realisateursCommuns,
            "genresCommuns" => $genresCommuns,
            "filmChecked" => $filmChecked,
            "filmToFind" => $filmToFind,
        ];
        return $result;
    }
}
