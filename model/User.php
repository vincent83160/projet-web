<?php
// Inclusion du fichier de connexion à MySQL
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';

// Déclaration de la classe User qui étend ConnexionMySql
class User extends ConnexionMySql
{
    // Déclaration des propriétés privées
    private static $data = array();
    private int $id;
    private string $email;
    private string $login;
    private string $password;
    private bool $is_verified;
    private string $role;

    // Getter pour l'ID
    function getId()
    {
        return $this->id;
    }

    // Getter pour l'email
    function getEmail()
    {
        return $this->email;
    }

    // Getter pour le login
    function getLogin()
    {
        return $this->login;
    }

    // Getter pour le mot de passe
    function getPassword()
    {
        return $this->password;
    }

    // Getter pour vérifier si l'utilisateur est vérifié
    function getIsVerified()
    {
        return $this->is_verified;
    }

    // Getter pour le rôle
    function getRole()
    {
        return $this->role;
    }

    // Méthode magique pour définir une propriété
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    // Constructeur de la classe
    function __construct($id, $email, $login, $password, $is_verified, $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->login = $login;
        $this->password = $password;
        $this->is_verified = $is_verified;
        $this->role = $role;
    }

    // Méthode statique pour obtenir une connexion à la base de données
    public static function getConnexion()
    {
        $db = new ConnexionMySql();
        $db->connexion();
        $pdo = $db->getPdo();

        return $pdo;
    }

    // Méthode statique pour créer une instance vide de User
    public static function createVide()
    {
        return new self(0, "", "", "", false, "");
    }

    // Méthode pour obtenir tous les utilisateurs
    public function getUsers()
    {
        $pdo = $this->getConnexion();
        $req = 'SELECT id, email, pseudo, role FROM user';
        $stmt = $pdo->prepare($req);
        $result = $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    // Méthode pour mettre à jour un utilisateur
    public function update($input, $value, $idUser)
    {
        $pdo = $this->getConnexion();
        $req = "UPDATE user SET " . $input . " = :value WHERE id = :idUser";
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':value', $value);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
    }

    // Méthode pour créer un nouvel utilisateur
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
        return $pdo->lastInsertId();
    }

    public function checkMail($email)
    {
        $pdo = $this->getConnexion();
        $req = 'SELECT * FROM user WHERE email = :email';
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':email', $email);
        $result = $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result;
    }

    // Méthode pour supprimer un utilisateur par son ID
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

    // Méthode pour obtenir un utilisateur par son ID
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

    // Méthode pour vérifier les informations de connexion
    public function checkLogin($email, $password)
    {
        $pdo = $this->getConnexion();
        $req = 'SELECT * FROM user WHERE email = :email';
        $stmt = $pdo->prepare($req);
        $stmt->bindParam(':email', $email);
        $result = $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (isset($result['password']) && password_verify($password, $result['password'])) {
            return $result;
        } else {
            return false;
        }
    }
}
?>
