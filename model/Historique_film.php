<?php
// Déclaration de la classe Historique_film
class Historique_film
{
    // Déclaration des propriétés privées
    private int $id;
    private int $id_film;
    private DateTime $date;

    // Constructeur de la classe
    function __construct(int $id, int $id_film, DateTime $date)
    {
        $this->id = $id;
        $this->id_film = $id_film;
        $this->date = $date;
    }

    // Méthode pour obtenir l'ID
    public function getId(): int
    {
        return $this->id;
    }

    // Méthode pour obtenir l'ID du film
    public function getIdFilm(): int
    {
        return $this->id_film;
    }

    // Méthode pour obtenir la date
    public function getDate(): DateTime
    {
        return $this->date;
    }

    // Méthode statique pour créer une instance vide de Historique_film
    public static function createVide()
    {
        return new self(0, 0, new DateTime());
    }

    // Méthode statique pour obtenir une connexion à la base de données
    public static function getConnexion()
    {
        $db = new ConnexionMySql();
        $db->connexion();
        $pdo = $db->getPdo();

        return $pdo;
    }

    // Méthode pour vérifier s'il y a déjà un film à trouver pour aujourd'hui
    public function checkIfFilmToFindToday()
    {
        $pdo = $this->getConnexion();
        
        // Vérifier s'il y a déjà un film pour aujourd'hui
        $req = "SELECT * FROM historique_film WHERE date = CURDATE()";
        $stmt = $pdo->prepare($req);
        $stmt->execute();
        $result = $stmt->fetch();
        
        if (!$result) { 
            // Sélectionner un film aléatoire et l'insérer avec la date d'aujourd'hui
            $req = "INSERT INTO historique_film (id_film, date)
                    VALUES ((SELECT id FROM film ORDER BY RAND() LIMIT 1), CURDATE())";
            $stmt = $pdo->prepare($req);
            $stmt->execute();
        }
    }
}
?>
