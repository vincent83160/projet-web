<?php
// Inclusion du fichier de connexion à MySQL
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';

// Déclaration de la classe Film
class Film
{
    // Déclaration des propriétés privées
    private int $id;
    private string $original_title;
    private DateTime $release_date;
    private string $poster_path;
    private int $duree;
    private string $classification;
    private string $synopsis;

    // Méthode magique pour définir une propriété
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    // Méthode magique pour obtenir une propriété
    function __get($name)
    {
        return $this->$name;
    }

    // Méthode statique pour obtenir une connexion à la base de données
    public static function getConnexion()
    {
        $db = new ConnexionMySql();
        $db->connexion();
        $pdo = $db->getPdo();

        return $pdo;
    }

    // Constructeur de la classe
    function __construct(int $id, string $original_title, DateTime $release_date, string $poster_path, int $duree, string $classification, string $synopsis)
    {
        $this->id = $id;
        $this->original_title = $original_title;
        $this->release_date = $release_date;
        $this->poster_path = $poster_path;
        $this->duree = $duree;
        $this->classification = $classification;
        $this->synopsis = $synopsis;
    }

    // Méthode statique pour créer une instance vide de Film
    public static function createVide()
    {
        return new self(0, "", new DateTime(), "", 0, "", "");
    }

    // Méthode pour mettre à jour un film
    public function update($input, $value, $idFilm)
    {
        $pdo = $this->getConnexion();
        $req = "UPDATE film SET " . $input . " = :value WHERE id = :idFilm";
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':idFilm', $idFilm);
        $stmt->debugDumpParams();
        $stmt->execute();
    }

    // Méthode pour créer un nouveau film
    public function create(string $original_title, string $release_date, string $poster_path, int $duree, string $classification, string $synopsis)
    {
        $pdo = $this->getConnexion();
        $req = "INSERT INTO film (original_title, release_date, poster_path, duree, classification, synopsis) VALUES (:original_title, :date, :poster_path, :duree, :classification, :synopsis)";
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':original_title', $original_title);
        $stmt->bindParam(':date', $release_date);
        $stmt->bindParam(':poster_path', $poster_path);
        $stmt->bindParam('duree', $duree);
        $stmt->bindParam('classification', $classification);
        $stmt->bindParam('synopsis', $synopsis);
        $stmt->execute();
    }

    // Méthode pour obtenir des films par titre similaire
    public function getFilmByTitreLike(string $original_title)
    {
        $original_title = "%" . $original_title . "%";
        $pdo = $this->getConnexion();
        $req = "SELECT * FROM film WHERE original_title LIKE :original_title LIMIT 10";
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':original_title', $original_title);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as &$row) {
            $row["bdd"] = true;
        }
        return $result;
    }

    // Méthode pour obtenir un film par son ID
    public function getFilmById(string $id)
    {
        $req = "SELECT *, YEAR(release_date) as release_date FROM film WHERE film.id = :id";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $film = $stmt->fetch(PDO::FETCH_ASSOC);

        // Obtenir les acteurs, réalisateurs, genres, pays et productions associés au film
        $film["acteurs"] = $this->getListIdActeursByIdFilm($id);
        $film["realisateurs"] = $this->getListIdRealisateursByIdFilm($id);
        $film["genres"] = $this->getGenresByIdFilm($id);
        $film["pays"] = $this->getPaysByIdFilm($id);
        $film["productions"] = $this->getProductionByIdFilm($id);
       
        return $film;
    }

    // Méthode pour obtenir la liste des acteurs par ID de film
    public function getListIdActeursByIdFilm(string $id)
    {
        $req = "SELECT id from personne inner join join_film_acteur on personne.id = join_film_acteur.id_acteur WHERE join_film_acteur.id_film = :id ORDER BY rang";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;
    }

    // Méthode pour obtenir la liste des réalisateurs par ID de film
    public function getListIdRealisateursByIdFilm(string $id)
    {
        $req = "SELECT id from personne inner join join_film_realisateur on personne.id = join_film_realisateur.id_realisateur WHERE join_film_realisateur.id_film = :id";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    // Méthode pour obtenir un acteur par son ID et l'ID du film
    public function getActeurByIdAndIdFilm(string $idActeur, string $idFilm)
    {
        $req = "SELECT id, name, image, rang FROM personne inner join join_film_acteur on personne.id = join_film_acteur.id_acteur WHERE join_film_acteur.id_acteur = :idActeur AND join_film_acteur.id_film = :idFilm ORDER BY rang";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':idActeur', $idActeur);
        $stmt->bindParam(':idFilm', $idFilm);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    // Méthode pour obtenir tous les films
    public function getFilms()
    {
        $req = "SELECT id, original_title, release_date, poster_path FROM film";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $result = $stmt->fetchAll();

        return $result;
    }

    // Méthode pour obtenir un réalisateur par son ID et l'ID du film
    public function getRealisateurByIdAndIdFilm(string $idReal, string $idFilm)
    {
        $req = "SELECT id, name, image FROM personne inner join join_film_realisateur on personne.id = join_film_realisateur.id_realisateur WHERE join_film_realisateur.id_realisateur = :idReal AND join_film_realisateur.id_film = :idFilm";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':idReal', $idReal);
        $stmt->bindParam(':idFilm', $idFilm);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }

    // Méthode pour obtenir les genres par ID de film
    public function getGenresByIdFilm(string $id)
    {
        $req = "SELECT genre FROM genre inner join join_film_genre on genre.id = join_film_genre.id_genre WHERE join_film_genre.id_film = :id";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN); 
        return $result;
    }

    // Méthode pour obtenir les pays par ID de film
    public function getPaysByIdFilm(string $id)
    {
        $req = "SELECT nom FROM pays inner join join_film_pays on pays.iso = join_film_pays.id_pays WHERE join_film_pays.id_film = :id";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN); 
        return $result;
    }

    // Méthode pour obtenir les productions par ID de film
    public function getProductionByIdFilm(string $id)
    {
        $req = "SELECT production.id FROM production inner join join_film_production on production.id = join_film_production.id_production WHERE join_film_production.id_film = :id";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN); 
        return $result;
    }

    // Méthode pour obtenir le film à trouver
    public function getFilmToFind()
    {
        $pdo = $this->getConnexion();
        $req = "SELECT * FROM historique_film ORDER BY date DESC LIMIT 1";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $film = $stmt->fetch(PDO::FETCH_ASSOC); 
        $film = $this->getFilmById($film["id_film"]); 
        return $film;
    }

    // Méthode pour supprimer un film par son ID
    public function deleteFilmByID(int $id)
    {
        $pdo = $this->getConnexion();
        $req = 'DELETE FROM film WHERE id = :id';
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $result = $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    // Méthode pour insérer une production
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

    // Méthode pour insérer un genre
    public function insertGenre($id, $genre)
    {
        $req = 'INSERT IGNORE INTO genre (id, genre) VALUES(:id, :genre)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':genre', $genre, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer une personne
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

    // Méthode pour insérer un film
    public function insertFilm($id, $original_title, $poster_path, $release_date, $overview, $runtime, $adult)
    {
        $req = 'INSERT IGNORE INTO film (id, original_title, poster_path, release_date, synopsis, duree, adult) VALUES(:id, :original_title, :poster_path, :release_date, :overview, :runtime, :adult)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':original_title', $original_title, PDO::PARAM_STR);
        $stmt->bindParam(':poster_path', $poster_path, PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $release_date, PDO::PARAM_STR);
        $stmt->bindParam(':overview', $overview, PDO::PARAM_STR);
        $stmt->bindParam(':runtime', $runtime, PDO::PARAM_STR);
        $stmt->bindParam(':adult', $adult, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer un pays
    public function insertPays($iso_3166_1, $name)
    {
        $req = 'INSERT IGNORE INTO pays (iso, nom) VALUES(:iso_3166_1, :name)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':iso_3166_1', $iso_3166_1, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer une langue
    public function insertLangue($iso_639_1, $name)
    {
        $req = 'INSERT IGNORE INTO langue (langue, iso) VALUES(:name, :iso)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':iso', $iso_639_1, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer une relation film-acteur
    public function insertJoinActeur($idFilm, $id_acteur, $rang)
    {
        $req = 'INSERT IGNORE INTO join_film_acteur (id_film, id_acteur, rang) VALUES(:idFilm, :id_acteur, :rang)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':idFilm', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_acteur', $id_acteur, PDO::PARAM_STR);
        $stmt->bindParam(':rang', $rang, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer une relation film-réalisateur
    public function insertJoinReal($idFilm, $id)
    {
        $req = 'INSERT IGNORE INTO join_film_realisateur (id_film, id_realisateur) VALUES(:idFilm, :id_realisateur)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':idFilm', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_realisateur', $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer une relation film-genre
    public function insertJoinGenre($idFilm, $id)
    {
        $req = 'INSERT IGNORE INTO join_film_genre (id_film, id_genre) VALUES(:id_film, :id_genre)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id_film', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_genre', $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer une relation film-pays
    public function insertJoinPays($idFilm, $id)
    {
        $req = 'INSERT IGNORE INTO join_film_pays (id_film, id_pays) VALUES(:id_film, :id_pays)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id_film', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_pays', $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer une relation film-langue
    public function insertJoinLangue($idFilm, $id)
    {
        $req = 'INSERT IGNORE INTO join_film_langue (id_film, id_langue) VALUES(:id_film, :id_langue)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id_film', $idFilm, PDO::PARAM_STR);
        $stmt->bindParam(':id_langue', $id, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour insérer une relation film-production
    public function insertJoinProductionFilm($id, $id_production)
    {
        $req = 'INSERT IGNORE INTO join_film_production (id_film, id_production) VALUES(:id, :id_production)';
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':id_production', $id_production, PDO::PARAM_STR);
        $stmt->execute();
    }

    // Méthode pour obtenir une production par son ID
    public function getProductionById($id)
    {
        $req = "SELECT * FROM production WHERE id = :id";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>
