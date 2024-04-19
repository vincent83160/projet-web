<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
class Film
{
    private int $id;
    private string $nom;
    private DateTime $date_sortie;
    private string $affiche;
    private int $duree;
    private string $classification;
    private string $synopsis;

    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    function __get($name)
    {
        return $this->$name;
    }

    public static function getConnexion()
    {
        $db = new ConnexionMySql();
        $db->connexion();
        $pdo = $db->getPdo();

        return $pdo;
    }

    function __construct(int $id, string $nom, DateTime $date_sortie, string $affiche, int $duree, string $classification, string $synopsis)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->date_sortie = $date_sortie;
        $this->affiche = $affiche;
        $this->duree = $duree;
        $this->classification = $classification;
        $this->synopsis = $synopsis;
    }
    public static function createVide()
    {
        return new self(0, "", new DateTime(), "", 0, "", "");
    }

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

    public function create(string $nom, string $date_sortie, string $affiche, int $duree, string $classification, string $synopsis)
    {

        $pdo = $this->getConnexion();
        $req = "INSERT INTO film (nom, date_sortie, affiche, duree, classification, synopsis) VALUES (:nom,:date,:affiche,:duree, :classification, :synopsis)";
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':date', $date_sortie);
        $stmt->bindParam(':affiche', $affiche);
        $stmt->bindParam('duree', $duree);
        $stmt->bindParam('classification', $classification);
        $stmt->bindParam('synopsis', $synopsis);
        $stmt->execute();
    }
    public function getFilmByTitreLike(string $nom)
    {
        $nom = "%" . $nom . "%";
        $pdo = $this->getConnexion();
        $req = "SELECT * FROM film WHERE nom LIKE :nom LIMIT 10";
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    public function getFilmById(string $id)
    {

        $req = "SELECT * FROM film WHERE film.id =:id ";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $film = $stmt->fetch(PDO::FETCH_ASSOC);
        $film["acteurs"] = $this->getListIdActeursByIdFilm($id);
        $film["realisateurs"] = $this->getListIdRealisateursByIdFilm($id);
        $film["genres"] = $this->getGenresByIdFilm($id);
        return $film;
    }

    public function getListIdActeursByIdFilm(string $id)
    {

        $req = "SELECT id from personne inner join join_film_acteur on personne.id = join_film_acteur.id_acteur WHERE join_film_acteur.id_film =:id ORDER BY rang";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $result;
    }

    public function getListIdRealisateursByIdFilm(string $id)
    {

        $req = "SELECT id from personne inner join join_film_realisateur on personne.id = join_film_realisateur.id_realisateur WHERE join_film_realisateur.id_film =:id ";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $result;
    }

    public function getActeurById(string $id)
    {

        $req = "SELECT id,name,image,rang FROM personne inner join join_film_acteur on personne.id = join_film_acteur.id_acteur WHERE join_film_acteur.id_acteur =:id ORDER BY rang";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getRealisateurById(string $id)
    {

        $req = "SELECT id,name,image FROM personne inner join join_film_realisateur on personne.id = join_film_realisateur.id_realisateur WHERE join_film_realisateur.id_realisateur =:id ";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getGenresByIdFilm(string $id)
    {

        $req = "SELECT id,genre FROM genre inner join join_film_genre on genre.id = join_film_genre.id_genre WHERE join_film_genre.id_film =:id ";
        $pdo = $this->getConnexion();
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }



    public function getFilmToFind()
    {
        $pdo = $this->getConnexion();
        $req = "SELECT * FROM historique_film ORDER BY date LIMIT 1";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $film = $stmt->fetch(PDO::FETCH_ASSOC);
        $film["acteurs"] = $this->getListIdActeursByIdFilm($film["id_film"]);
        $film["realisateurs"] = $this->getListIdRealisateursByIdFilm($film["id_film"]);
        $film["genres"] = $this->getGenresByIdFilm($film["id_film"]);
        return $film;
    }


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
}
