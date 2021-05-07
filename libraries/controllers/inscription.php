<?php
if (isset($_SESSION['user'])) {
        header("Location: profil");
        exit();
}
require(ROOT . '/libraries/models/notificationsmodel.php');

//tester si les champs sont vides

if (isset($_POST)) {
        if (isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['ville'])) {
                // tester si les 2 mots de passe ont bien la même valeur
                if ($_POST['password'] != $_POST['password2']) {
                        addFlash('error', 'Les mots de passe saisis ne correspondent pas');
                        header('Location: inscription');
                        exit();
                }

                //tester l'email (format)
                if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                        addFlash('error', 'Le mail n\'est pas valide');
                        header('Location: inscription');
                        exit();
                }

                require('libraries/models/usermodel.php');

                $user = getUserFromEmail($pdo, $_POST['mail']);

                //test si l'email n'existe pas dans la base de données
                if ($user) {
                        addFlash('error', 'Vous êtes déjà inscrit');
                        header('Location: connexion');
                        exit();
                }

                $pseudo = getUserFromPseudo($pdo, $_POST['pseudo']);

                //test si le pseudo n'existe pas dans la base de données
                if ($pseudo) {
                        addFlash('error', 'Ce pseudo est déjà utilisé, merci d\'en choisir un autre');
                        header('Location: inscription');
                        exit();
                }

                //la personne n'est pas dans la BDD on peut l'inscrire
                //encrypter le mot de passe
                //https://www.php.net/manual/fr/function.openssl-encrypt
                $pwd_crypted = cryptPassword($_POST['password']);
                $pseudo = htmlspecialchars($_POST['pseudo']);
                $mail = htmlspecialchars($_POST['mail']);
                $ville = htmlspecialchars($_POST['ville']);

                //on insère les informations en BDD
                insertUser($pdo, $pseudo, $pwd_crypted, $mail, $ville);

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
