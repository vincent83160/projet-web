<?php


class ConnexionMySql {
    private $host = "localhost";
    private $username = "web";
    private $password = "web";
    private $dbname = "bdd-web";
    private $charset = "utf8mb4";
    private $pdo;

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


 
