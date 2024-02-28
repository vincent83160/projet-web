<?php
    session_start();
    if(isset($_SESSION["nom"])){
        include "./../vues/membre.php";
    }
    else{
        if(isset($_GET["erreur"])){
            if($_GET["erreur"]==true){
                include "./../vues/erreurMsg.php";
            } 
        }         
        include "./../vues/formCo.php";
    }
