<?php
    require("../model/user.php");
    session_start(); 
    echo"lost in translation";
    switch($_POST['input']){
        case 'email':
            $_SESSION['user']->setEmail($_POST['email']);
            header('Location: ../model/membre.php?mail');
            break;
        case 'pwd':
            $_SESSION['user']->setPassword($_POST['pwd']);
            header('Location: ../model/membre.php?pwd');
            break;
        case 'pseudo':
            $_SESSION['user']->setPseudo($_POST['pseudo']);
            header('Location: ../model/membre.php?pseudo');
            break;  
        case 'isVerified':
            $_SESSION['user']->setIsVerified($_POST['isVerified']);
            header('Location: ../model/membre.php?isv');
            break;
        case 'role': 
            $_SESSION['user']->setRole($_POST['role']); 
            header('Location: ../model/membre.php?role  '); 
            break;
    }
