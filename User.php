<?php 

class User {
    private $id;
    private $login;
    private $password;
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getPassword() {
        return $this->password;
    }

    public function connect() {
        $query = $this->db->prepare("SELECT * FROM user WHERE login = :login AND password = :password");
        $query->execute([
            "login" => $this->login,
            "password" => $this->password
        ]);
        $result = $query->fetch();
        if ($result) {
            $_SESSION['id'] = $result['id'];
            $_SESSION['login'] = $result['login'];
            return true;
        } else {
            return false;
        }
    }
}