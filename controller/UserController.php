<?php
// Inclusion du modèle User
require_once $_SERVER["DOCUMENT_ROOT"] . '/model/User.php';

// Déclaration de la classe UserController
class UserController
{
    // Méthode pour afficher la page membre
    public function membre()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/membre.php";
    }

    // Méthode pour modifier un utilisateur
    public function userModif($params)
    {
        //require("../model/User.php")
        foreach ($params as $key => $value) {
            $input = $key;
            // Vérifier si l'utilisateur connecté est celui à modifier
            if ($_SESSION["id"] == $params["id"]) {
                $_SESSION[$input] = $value;

                $db = user::createVide();
                // Hacher le mot de passe avant de le mettre à jour
                if ($input == "password") {
                    $value = password_hash($value, PASSWORD_DEFAULT);
                }
                $db->update($input, $value, $_SESSION['id']);
            }
        }
        // Redirection vers la page membre
        header('Location: /user/membre');
    }

    // Méthode pour déconnecter l'utilisateur
    public function logout()
    {
        //session_start();
        session_destroy();
        header("location: /default/accueil");
    }

    // Méthode pour connecter l'utilisateur
    public function login()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        require_once $_SERVER["DOCUMENT_ROOT"] . '/model/User.php';
        $db = user::createVide();

        $erreur = "";
        // Vérifier si l'utilisateur est déjà connecté
        if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
            header("location: /default/accueil");
        } else {
            // Récupérer les informations de connexion
            $_POST['password'] = isset($_POST['password']) ? $_POST['password'] : "";
            $_POST['email'] = isset($_POST['email']) ? $_POST['email'] : "";

            $result = $db->checkLogin($_POST['email'], $_POST['password']);
            if ($result) {
                // Initialiser la session avec les informations de l'utilisateur
                $user = new User($result["id"], $result["email"], $result["pseudo"], $result["password"], $result["is_verified"], $result["role"]);

                $_SESSION['id'] = $result["id"];
                $_SESSION['email'] = $result["email"];
                $_SESSION['pseudo'] = $result["pseudo"];
                $_SESSION['role'] = $result["role"];

                header("Location: /game/game");
            } elseif ($_POST['email'] != "" && $_POST['password'] != "") {
                $erreur = "Mauvais login ou mot de passe";
                require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/login.php";
            } else {
                require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/login.php";
            }
        }
    }

    // Méthode pour l'inscription d'un nouvel utilisateur
    public function signIn()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . '/model/User.php';
        if (isset($_POST['mail'])) {
            $db = user::createVide();
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $lastId =  $db->create($_POST['mail'], $_POST['pseudo'], $password, 0, 'USER');
            $emailContent = $this->simulateConfirmationEmail($_POST['mail'], $_POST['pseudo'], $lastId);

            echo $emailContent;
            require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/signInConfirm.php";
        } else {
            require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/signIn.php";
        }
    }

    // Méthode pour afficher la page de récupération de mot de passe
    public function mdp()
    {
        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/motDePasse.php";
    }
    //permet de confirmer un compte
    public function confirmcompte($params)
    {
        $id = urldecode($params["id"]);
        $db = user::createVide();
        $db->update("is_verified", "1", $id);

        require_once $_SERVER["DOCUMENT_ROOT"] . "/vue/confirmCompte.php";
    }

    // Méthode pour simuler l'envoi d'un e-mail de confirmation
    private function simulateConfirmationEmail($email, $pseudo, $id)
    {
        // Contenu de l'e-mail
        $subject = 'Confirmation d\'inscription';
        $body = "Bonjour $pseudo,<br><br>Merci de vous être inscrit. Veuillez confirmer votre adresse e-mail en cliquant sur le lien suivant : <a href='http://web/user/confirmCompte/id=$id'>Confirmer mon e-mail</a><br><br>Cordialement,<br>L'équipe de votre site";

        // Simulation de l'e-mail
        $emailContent = "<strong>To:</strong> $email<br>";
        $emailContent .= "<strong>Subject:</strong> $subject<br>";
        $emailContent .= "<strong>Body:</strong><br>$body";

        return $emailContent;
    }
}
