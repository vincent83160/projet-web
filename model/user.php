<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/ConnexionMySql.php';
class User extends ConnexionMySql{
   private static $data = array();
    private int $id;
    private string $email; 
    private string $pseudo;
    private string $password;
    private bool $is_verified;
    private String $role;

    //GETTER
    function getId(){
        return $this->id;
    }
    function getEmail(){
        return $this->email;
    }
    function getPseudo(){
        return $this->pseudo;
    }
    function getPassword(){
        return $this->password;
    }
    function getIsVerified(){
        return $this->is_verified;
    }
    function getRole(){
        return $this->role;
    }
    //SETTER
    public function __set($name, $value) {
        $this->$name= $value;
        
    }
    //CONSTRUCTEUR
    function __construct($id, $email, $pseudo, $password, $is_verified, $role){
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
}