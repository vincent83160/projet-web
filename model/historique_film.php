<?php
class Historique_film
{
    private int $id;
    private int $id_film;
    private DateTime $date;

    function __construct(int $id, int $id_film, DateTime $date)
    {
        $this->id = $id;
        $this->id_film = $id_film;
        $this->date = $date;
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getIdFilm(): int
    {
        return $this->id_film;
    }
    public function getDate(): DateTime
    {
        return $this->date;
    }
    public static function createVide()
    {
        return new self(0, 0, new DateTime());
    }

    public static function getConnexion()
    {
        $db = new ConnexionMySql();
        $db->connexion();
        $pdo = $db->getPdo();

        return $pdo;
    }

   public function checkIfFilmToFindToday()
{
    $pdo = $this->getConnexion();
    
    // Vérifier s'il y a déjà un film pour aujourd'hui
    $req = "SELECT * FROM historique_film WHERE date = CURDATE()";
    $stmt = $pdo->prepare($req);
    $stmt->execute();
    $result = $stmt->fetch();
    
    if (!$result) { 
        // Sélectionner un film aléatoire et insérer avec la date d'aujourd'hui
        $req = "INSERT INTO historique_film (id_film, date)
                VALUES ((SELECT id FROM film ORDER BY RAND() LIMIT 1), CURDATE())";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        
    }
    
}

}
