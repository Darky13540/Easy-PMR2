<?php
session_start();
require 'notifications.php';

if (isset($_POST)) {
    if (isset($_POST['password']) && isset($_POST['password2'])) {
            // tester si les 2 mots de passe ont bien la même valeur
            if ($_POST['password'] != $_POST['password2']) {
                    addFlash('error', 'Les mots de passe saisis ne correspondent pas');
                    header('Location: editPwd.php');
                    die();
            }

            require 'functionPass.php';
            require 'bdconnect.php';
            require 'user.php';
            
            
            $query = $pdo->prepare('SELECT password FROM users WHERE id = ? LIMIT 1');

            //executer la requête
            $query->execute([$_SESSION['user']['id']]);

            $user = $query->fetch(PDO::FETCH_ASSOC);



            /* si le user existe, on vérifie le MDP */
            if (!verifPassword($_POST['password3'], $user['password'])) {
                addFlash('error', 'Merci de saisir votre mot de passe actuel');
                header('Location: editPwd.php');
            die();
            }

            //encrypter le nouveau mot de passe
            //https://www.php.net/manual/fr/function.openssl-encrypt
            $pwd_crypted = cryptPassword($_POST['password']);
            $userId = $_SESSION['user']['id'];
            updatePwd($pdo, $pwd_crypted, $userId);

            //on redirige vers la page de profil
            addFlash('success', 'La modification est bien prise en compte');
            header("Location: profil.php");
            exit();
    }
};

require('Views/editPwd.phtml');