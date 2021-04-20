<?php
session_start();
require 'notifications.php';

if (!isset($_SESSION['user'])) {
    addFlash('error', 'Vous devez d\'abord vous connecter');
    header("Location: connexion.php");
    exit();
};

if (!empty($_POST)) {
    if (
        isset($_POST['mail']) && isset($_POST['ville'])
        && !empty($_POST['mail'] && !empty($_POST['ville']))
    ) {
        require 'bdconnect.php';
        require 'user.php';

        $mail = htmlspecialchars($_POST['mail']);
        $ville = htmlspecialchars($_POST['ville']);
        $userId = $_SESSION['user']['id'];
        
        updateUser($pdo, $mail, $ville, $userId);

        //on stocke les nouvelles infos dans $_SESSION
        $_SESSION['user'] = [
            'id' => intVal($userId),
            'mail' => htmlspecialchars($_POST["mail"]),
            'ville' => htmlspecialchars($_POST["ville"]),
            'pseudo' => htmlspecialchars($_SESSION['user']['pseudo'])
        ];

        //on redirige vers la page de profil
        addFlash('success', 'La demande de modification est bien prise en compte');
        header("Location: profil.php");
        exit();
    }
}

require ('Views/editProfil.phtml');
