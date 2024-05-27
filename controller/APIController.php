<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';

class ApiController extends ConnexionMySql
{

    public static function getConnexion()
    {
        $db = new ConnexionMySql();
        $db->connexion();
        $pdo = $db->getPdo();

        return $pdo;
    }

    function getFilmsForGame($query = '')
    {
        $apiKey = '0dab7f323e77fc24fe9a13a247dcd82a';
        // URL de l'API de TMDb
        $url = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=" . urlencode($query) . "&language=fr-FR";
        $response = json_decode(file_get_contents($url));
        return $response->results;
    }

    function getFilmsApi($query = '')
    {
        $query = 'iron';
        $apiKey = '0dab7f323e77fc24fe9a13a247dcd82a';
        $db = Film::createVide();

        // URL de l'API de TMDb
        $url = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=" . urlencode($query) . "&language=fr-FR";
        $response = json_decode(file_get_contents($url));



        foreach ($response->results as $result) {


            $url = "https://api.themoviedb.org/3/movie/$result->id?language=fr-FR&api_key=$apiKey";
            $detailsFilm = json_decode(file_get_contents($url));
            $db->insertFilm($detailsFilm->id, $detailsFilm->title, $detailsFilm->poster_path, $detailsFilm->release_date, $detailsFilm->overview, $detailsFilm->runtime, $detailsFilm->adult);

            foreach ($detailsFilm->production_companies as $production_companies) {

                $db->insertProduction($production_companies->id, $production_companies->name, $production_companies->logo_path);
                $db->insertJoinProductionFilm($detailsFilm->id, $production_companies->id);
            }
            foreach ($detailsFilm->genres as $genre) {
                $db->insertGenre($genre->id, $genre->name);

                $db->insertJoinGenre($detailsFilm->id, $genre->id);
            }
            foreach ($detailsFilm->spoken_languages as $langue) {
                $db->insertLangue($langue->iso_639_1, $langue->name);

                $db->insertJoinLangue($detailsFilm->id, $langue->name);
            }

            foreach ($detailsFilm->production_countries as $pays) {
                $db->insertPays($pays->iso_3166_1, $pays->name);

                $db->insertJoinPays($detailsFilm->id, $pays->iso_3166_1);
            }
            $url = "https://api.themoviedb.org/3/movie/$result->id/credits?language=fr-FR&api_key=$apiKey";
            $detailsFilm = json_decode(file_get_contents($url));


            foreach ($detailsFilm->cast as $acteur) {
                $db->insertPersonne($acteur->id, $acteur->name, $acteur->profile_path);

                if ($acteur->known_for_department == "Directing") {
                    $realisateurs[] = ["name" => $acteur->name, "image" => $acteur->profile_path, "id" => $acteur->id];

                    $db->insertPersonne($acteur->id, $acteur->name, $acteur->profile_path);
                    $db->insertJoinReal($detailsFilm->id, $acteur->id);
                } else {
                    $db->insertPersonne($acteur->id, $acteur->name, $acteur->profile_path);
                    $db->insertJoinActeur($detailsFilm->id, $acteur->id, $acteur->order);
                }
            }
        }
    }
    function getFilmById($id)
    {
        $db = Film::createVide();


        $apiKey = '0dab7f323e77fc24fe9a13a247dcd82a';

        // URL de l'API de TMDb pour obtenir les détails du film par son ID
        $url = "https://api.themoviedb.org/3/movie/$id?language=fr-FR&api_key=$apiKey";
        $detailsFilm = json_decode(file_get_contents($url));

        if (!$detailsFilm) {
            return;
        }

        // Insérer les détails du film
        $db->insertFilm($detailsFilm->id, $detailsFilm->title, $detailsFilm->poster_path, $detailsFilm->release_date, $detailsFilm->overview, $detailsFilm->runtime, $detailsFilm->adult);

        // Insérer les sociétés de production
        foreach ($detailsFilm->production_companies as $production_companies) {
            $db->insertProduction($production_companies->id, $production_companies->name, $production_companies->logo_path);
            $db->insertJoinProductionFilm($detailsFilm->id, $production_companies->id);
        }

        // Insérer les genres
        foreach ($detailsFilm->genres as $genre) {
            $db->insertGenre($genre->id, $genre->name);
            $db->insertJoinGenre($detailsFilm->id, $genre->id);
        }

        // Insérer les langues parlées
        foreach ($detailsFilm->spoken_languages as $langue) {
            $db->insertLangue($langue->iso_639_1, $langue->name);
            $db->insertJoinLangue($detailsFilm->id, $langue->name);
        }

        // Insérer les pays de production
        foreach ($detailsFilm->production_countries as $pays) {
            $db->insertPays($pays->iso_3166_1, $pays->name);
            $db->insertJoinPays($detailsFilm->id, $pays->iso_3166_1);
        }

        // URL de l'API de TMDb pour obtenir les crédits du film par son ID
        $url = "https://api.themoviedb.org/3/movie/$id/credits?language=fr-FR&api_key=$apiKey";
        $creditsFilm = json_decode(file_get_contents($url));

        if (!$creditsFilm) {
            return;
        }
        // Insérer les acteurs et réalisateurs
        foreach ($creditsFilm->cast as $acteur) {
            $db->insertPersonne($acteur->id, $acteur->name, $acteur->profile_path);
            $db->insertJoinActeur($detailsFilm->id, $acteur->id, $acteur->order);
        }
        foreach ($creditsFilm->crew as $real) {
            if ($real->job == "Director") {
                $db->insertPersonne($real->id, $real->name, $real->profile_path);
                $db->insertJoinReal($detailsFilm->id, $real->id);
            }
        }
    }
}
