<?php
session_start();
if (isset($_SESSION['user'])) {
        header("Location: profil.php");
        exit();
}

//tester si les champs sont vides
require 'notifications.php';

if (isset($_POST)) {
        if (isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['ville'])) {
                // tester si les 2 mots de passe ont bien la même valeur
                if ($_POST['password'] != $_POST['password2']) {
                        addFlash('error', 'Les mots de passe saisis ne correspondent pas');
                        header('Location: inscription.php');
                        exit();
                }

                //tester l'email (format)
                if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                        addFlash('error', 'Le mail n\'est pas valide');
                        header('Location: inscription.php');
                        exit();
                }

                require 'functionPass.php';
                require 'bdconnect.php';
                require 'user.php';

                $user = getUserFromEmail($pdo, $_POST['mail']);

                //test si l'email n'existe pas dans la base de données
                if ($user) {
                        addFlash('error', 'Vous êtes déjà inscrit');
                        header('Location: connexion.php');
                        exit();
                }

                $pseudo = getUserFromPseudo($pdo, $_POST['pseudo']);

                //test si le pseudo n'existe pas dans la base de données
                if ($pseudo) {
                        addFlash('error', 'Ce pseudo est déjà utilisé, merci d\'en choisir un autre');
                        header('Location: inscription.php');
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

                //on stocke dans $_SESSION les infos
                $_SESSION['user'] = [
                        'id' => intVal($id),
                        'pseudo' => htmlspecialchars($_POST["pseudo"]),
                        'mail' => htmlspecialchars($_POST["mail"]),
                        'ville' => htmlspecialchars($_POST["ville"])
                ];

                //on redirige vers la page de profil
                addFlash('success', 'L\'inscription est bien prise en compte');
                header("Location: profil.php");
                exit();
        }
};
require 'Views/inscription.phtml';
