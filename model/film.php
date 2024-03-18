<?php
    require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
    class Film extends ConnexionMySql{
        private int $id;
        private string $nom;
        private string $date_sortie;
        private string $affiche;
        private int $duree;
        private string $classification;
        private string $synopsis;

        public function __set($name, $value)
        {
            $this->$name = $value;
        }
        function __get($name){
            return $this->$name;
        }

        public static function getConnexion()
        { 
            $db = new ConnexionMySql();
            $db->connexion();
            $pdo = $db->getPdo();
            
            return $pdo;  
        }

        function __construct(int $id, string $nom, string $date_sortie, string $affiche, int $duree, string $classification, string $synopsis){
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
            return new self(0, "", "", "",0,"","");
        }

        public function update($input, $value,$idFilm)
        {
            $pdo = $this->getConnexion();
            $req = "UPDATE film SET " . $input . " = :value WHERE id = :idFilm";
            $stmt = $pdo->prepare($req); 
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':idFilm', $idFilm); 
            $stmt->debugDumpParams();
            $stmt->execute();
        }

        public function create( string $nom, string $date_sortie, string $affiche, int $duree, string $classification, string $synopsis)
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

            public function geFilmByTitle(string $titre)
        {
            $pdo = $this->getConnexion();
            $req = "SELECT * FROM film WHERE nom like '%".$titre."%' LIMIT 10";
           
            $stmt = $pdo->prepare($req);
            $result = $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }
    }