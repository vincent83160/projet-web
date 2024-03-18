<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
class User extends ConnexionMySql
{

    private static $data = array();
    private int $id;
    private string $email;
    private string $pseudo;
    private string $password;
    private bool $is_verified;
    private String $role;


 

    //GETTER
    function getId()
    {
        return $this->id;
    }
    function getEmail()
    {
        return $this->email;
    }
    function getPseudo()
    {
        return $this->pseudo;
    }
    function getPassword()
    {
        return $this->password;
    }
    function getIsVerified()
    {
        return $this->is_verified;
    }
    function getRole()
    {
        return $this->role;
    }
    //SETTER
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    //CONSTRUCTEUR
    function __construct($id, $email, $pseudo, $password, $is_verified, $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->pseudo = $pseudo;
        $this->password = $password;
        $this->is_verified = $is_verified;
        $this->role = $role;
        $this->email = $email;
        $this->password = $password;
        $this->is_verified = $is_verified;
        $this->role = $role;
    }

    public static function getConnexion()
    { 
        $db = new ConnexionMySql();
        $db->connexion();
        $pdo = $db->getPdo();
        
        return $pdo;  
    }

    public static function createVide()
    {
        return new self(0, "", "", "", false, "");
    }

 
public function update($input, $value,$idUser)
    {
        $pdo = $this->getConnexion();
        $req = "UPDATE user SET " . $input . " = :value WHERE id = :idUser";
        $stmt = $pdo->prepare($req); 
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':idUser', $idUser);  
        $stmt->execute();
    }

public function create($email, $pseudo, $password, $is_verified, $role)
    {
        
        $pdo = $this->getConnexion();
        $req = "INSERT INTO user (email, pseudo, password, is_verified, role) VALUES (:email, :pseudo, :password, :is_verified, :role)";
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':is_verified', $is_verified);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
    }



    public function deleteUserByID($id)
    {
        $pdo = $this->getConnexion();
        $req = 'DELETE FROM user WHERE id = :id';
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id); 
        $result = $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function getUserByID($id)
    {
        $pdo = $this->getConnexion();
        $req = 'SELECT * FROM user WHERE id = :id';
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':id', $id); 
        $result = $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    public function checkLogin($login, $password)
    {
        $pdo = $this->getConnexion();
        $req = 'SELECT * FROM user WHERE login = :login AND password = :password';
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $result = $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}
