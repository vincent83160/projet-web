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
 
    function getFilmsForGame($query ='')
    {
        $apiKey = '0dab7f323e77fc24fe9a13a247dcd82a'; 
        // URL de l'API de TMDb
        $url = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=".urlencode($query)."&language=fr-FR";
        $response = json_decode(file_get_contents($url)); 
    return $response->results;

    }
    function getFilmsApi($query ='')
    {
        $apiKey = '0dab7f323e77fc24fe9a13a247dcd82a';
        // Terme de recherche 
//  


        // URL de l'API de TMDb
        $url = "https://api.themoviedb.org/3/search/movie?api_key=$apiKey&query=".urlencode($query)."&language=fr-FR";
        $response = json_decode(file_get_contents($url));
    
 

        foreach ($response->results as $result) {


            $url = "https://api.themoviedb.org/3/movie/$result->id?language=fr-FR&api_key=$apiKey";
            $detailsFilm = json_decode(file_get_contents($url));
            $this->insertFilm($detailsFilm->id, $detailsFilm->title, $detailsFilm->poster_path, $detailsFilm->release_date, $detailsFilm->overview, $detailsFilm->runtime, $detailsFilm->adult);
  
            foreach ($detailsFilm->production_companies as $production_companies) {

                $this->insertProduction($production_companies->id, $production_companies->name, $production_companies->logo_path);
                $this->insertJoinProductionFilm($detailsFilm->id, $production_companies->id);
            }
            foreach ($detailsFilm->genres as $genre) {
                $this->insertGenre($genre->id, $genre->name);

                $this->insertJoinGenre($detailsFilm->id, $genre->id);
            }
            foreach ($detailsFilm->spoken_languages as $langue) {
                $this->insertLangue($langue->iso_639_1, $langue->name);

                $this->insertJoinLangue($detailsFilm->id, $langue->name);
            }

            foreach ($detailsFilm->production_countries as $pays) {
                $this->insertPays($pays->iso_3166_1, $pays->name);
                
                $this->insertJoinPays($detailsFilm->id, $pays->iso_3166_1);
            }
            $url = "https://api.themoviedb.org/3/movie/$result->id/credits?language=fr-FR&api_key=$apiKey";
            $detailsFilm = json_decode(file_get_contents($url));
 
 
            foreach ($detailsFilm->cast as $acteur) {
                $this->insertPersonne($acteur->id, $acteur->name, $acteur->profile_path);

                if ($acteur->known_for_department == "Directing") {
                    $realisateurs[] = ["name" => $acteur->name, "image" => $acteur->profile_path, "id" => $acteur->id];

                    $this->insertPersonne($acteur->id, $acteur->name, $acteur->profile_path);
                    $this->insertJoinReal( $detailsFilm->id, $acteur->id);
                } else {
                    $this->insertPersonne($acteur->id, $acteur->name, $acteur->profile_path); 
                    $this->insertJoinActeur( $detailsFilm->id, $acteur->id, $acteur->order);

                }
            }
        }
    }



    public function insertProduction($id, $name, $logo_path)
    {
        $req = 'INSERT IGNORE INTO production (id, nom, logo) VALUES(:id, :name, :logo_path)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':logo_path', $logo_path, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insertGenre($id, $genre)
    {
        $req = 'INSERT IGNORE INTO genre (id, genre) VALUES(:id, :genre)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function insertPersonne($id, $name, $profile_path)
    {
        $req = 'INSERT IGNORE INTO personne (id, name, image) VALUES(:id, :name, :profile_path)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':profile_path', $profile_path, PDO::PARAM_STR);
        $stmt->execute(); 
    }

    public function insertFilm($id, $title, $poster_path, $release_date, $overview, $runtime, $adult)
    {
        $req = 'INSERT IGNORE INTO film (id, nom, affiche, date_sortie, synopsis, duree, adult) VALUES(:id, :title, :poster_path, :release_date, :overview, :runtime, :adult)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':poster_path', $poster_path, PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $release_date, PDO::PARAM_STR);
        $stmt->bindParam(':overview', $overview, PDO::PARAM_STR);
        $stmt->bindParam(':runtime', $runtime, PDO::PARAM_STR);
        $stmt->bindParam(':adult', $adult, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insertPays($iso_3166_1, $name)
    {
        $req = 'INSERT IGNORE INTO pays (iso, nom) VALUES(:iso_3166_1, :name)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':iso_3166_1', $iso_3166_1, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insertLangue($iso_639_1, $name)
    {
        $req = 'INSERT IGNORE INTO langue (langue, iso) VALUES(:name, :iso)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':iso', $iso_639_1, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function insertJoinActeur($idFilm, $id_acteur, $rang)
    {
        $req = 'INSERT IGNORE INTO join_film_acteur (id_film, id_acteur,rang) VALUES(:idFilm, :id_acteur,:rang)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':idFilm', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_acteur', $id_acteur, PDO::PARAM_STR);
        $stmt->bindParam(':rang', $rang, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function insertJoinReal($idFilm, $id)
    {
        $req = 'INSERT IGNORE INTO join_film_realisateur (id_film, id_realisateur) VALUES(:idFilm, :id_realisateur)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':idFilm', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_realisateur', $id, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function insertJoinGenre($idFilm, $id)
    {
        $req = 'INSERT IGNORE INTO join_film_genre (id_film, id_genre) VALUES(:id_film, :id_genre)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id_film', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_genre', $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function insertJoinPays($idFilm, $id)
    {
        $req = 'INSERT IGNORE INTO join_film_pays (id_film, id_pays) VALUES(:id_film, :id_pays)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id_film', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_pays', $id, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function insertJoinLangue($idFilm, $id)
    {
        $req = 'INSERT IGNORE INTO join_film_langue (id_film, id_langue) VALUES(:id_film, :id_langue)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id_film', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_langue', $id, PDO::PARAM_STR);
        $stmt->execute();
    }
    public function insertJoinProductionFilm($id, $id_production)
    {
        $req = 'INSERT IGNORE INTO join_film_production (id_film, id_production) VALUES(:id, :id_production)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':id_production', $id_production, PDO::PARAM_STR);
        $stmt->execute();
    }
}
