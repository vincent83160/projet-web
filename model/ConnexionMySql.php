<?php


class ConnexionMySql {
    // pour travailler en prod
    private $host = "mysql-pleinlabobine.alwaysdata.net;port=3306";
    private $username = "360526";
    private $password = "Cnam2024+*";
    private $dbname = "pleinlabobine_bdd-web";
    private $charset = "utf8mb4";
    private $pdo;
    // pour travailler en local
    // private $host = "localhost";
    // private $username = "web";
    // private $password = "web";
    // private $dbname = "bdd-web";
    // private $charset = "utf8mb4";
    // private $pdo;

    public function __construct(){

    }
    public function connexion() {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";
  
        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    function getPdo(){
        return $this->pdo;
    }
   


}


 
