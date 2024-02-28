
<?php
    include('./../modeles/user.php');
    $id=0;
    $email="mland.d@gg.com"; 
    $pseudo="pzk";
    $password="mdp";
    $is_verified=true;
    $role="user";
    $co= new User($id,$email,$pseudo,$password,$is_verified,$role);
    if($_POST!=NULL){
        if($_POST["nom"]!=$co->getPseudo()||$_POST["mdp"]!=$co->getPassword()){
            header("Location: connection.php?erreur=true");
        }
        else{
            session_start();
            $_SESSION["id"]=$co->getId();
            $_SESSION["email"]=$co->getEmail();
            $_SESSION["nom"]=$co->getPseudo();
            $_SESSION["pwd"]=$co->getPassword();
            $_SESSION["isVerified"]= $co->getIsVerified();
            $_SESSION["role"]=$co->getRole();
            header("Location: connection.php");
        }
    }
?>

