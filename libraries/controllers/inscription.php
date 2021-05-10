<?php
if (isset($_SESSION['user'])) {
        header("Location: profil");
        exit();
}
require(ROOT . '/libraries/models/notificationsmodel.php');

//On teste si les champs sont vides
if (isset($_POST)) {
        if (isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['ville'])) {
                
                //On teste si les 2 mots de passe ont bien la même valeur
                if ($_POST['password'] != $_POST['password2']) {
                        addFlash('error', 'Les mots de passe saisis ne correspondent pas');
                        header('Location: inscription');
                        exit();
                }

                //On teste l'email (format)
                if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                        addFlash('error', 'Le mail n\'est pas valide');
                        header('Location: inscription');
                        exit();
                }

                require('libraries/models/usermodel.php');

                //On appelle la BDD pour chercher si un user a ce mail
                $user = getUserFromEmail($pdo, $_POST['mail']);

                //test si l'email n'existe pas dans la base de données
                if ($user) {
                        addFlash('error', 'Vous êtes déjà inscrit');
                        header('Location: connexion');
                        exit();
                }

                //On recherche si le pseudo est déjà utilisé en BDD
                $pseudo = getUserFromPseudo($pdo, $_POST['pseudo']);

                //test si le pseudo n'existe pas dans la base de données
                if ($pseudo) {
                        addFlash('error', 'Ce pseudo est déjà utilisé, merci d\'en choisir un autre');
                        header('Location: inscription');
                        exit();
                }

                //la personne n'est pas dans la BDD on peut l'inscrire
                //On encrypte le mot de passe
                $pwd_crypted = cryptPassword($_POST['password']);
                $pseudo = htmlspecialchars($_POST['pseudo']);
                $mail = htmlspecialchars($_POST['mail']);
                $ville = htmlspecialchars($_POST['ville']);

                //on insère les informations en BDD
                insertUser($pdo, $pseudo, $pwd_crypted, $mail, $ville);

                //On récupère immédiatement les infos de la BDD par son mail
                $infoUser = getUserFromEmail($pdo, $_POST["mail"]);

                //on stocke dans $_SESSION les infos
                $_SESSION['user'] = [
                        'id' => intval($infoUser['id']),
                        'pseudo' => htmlspecialchars($infoUser['pseudo']),
                        'mail' => htmlspecialchars($infoUser["mail"]),
                        'ville' => htmlspecialchars($infoUser["ville"]), 
                        'role' => intval($infoUser['role']) 
                ];

                //on redirige vers la page de profil
                addFlash('success', 'L\'inscription est bien prise en compte');
                header("Location: profil");
                exit();
        }
};

$template = 'inscription.phtml';

require 'views/layout.phtml';
