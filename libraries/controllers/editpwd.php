<?php
require(ROOT . '/libraries/models/notificationsmodel.php');

if (isset($_POST)) {
    if (isset($_POST['password']) && isset($_POST['password2'])) {
        // tester si les 2 mots de passe ont bien la même valeur
        if ($_POST['password'] != $_POST['password2']) {
            addFlash('error', 'Les mots de passe saisis ne correspondent pas');
            header('Location: editpwd');
            die();
        }

        require(ROOT . '/libraries/models/usermodel.php');

        $user = getUserFromId($pdo, $_SESSION['user']['id']);

        /* si le user existe, on vérifie le MDP */
        if (!verifPassword($_POST['password3'], $user['password'])) {
            addFlash('error', 'Merci de saisir votre mot de passe actuel');
            header('Location: editpwd');
            die();
        }

        //encrypter le nouveau mot de passe
        //https://www.php.net/manual/fr/function.openssl-encrypt
        $pwd_crypted = cryptPassword($_POST['password']);
        $userId = $_SESSION['user']['id'];
        updatePwd($pdo, $pwd_crypted, $userId);

        //on redirige vers la page de profil
        addFlash('success', 'La modification est bien prise en compte');
        header("Location: profil");
        exit();
    }
};

$template = 'editpwd.phtml';

require('views/layout.phtml');
