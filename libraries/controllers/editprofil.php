<?php
require(ROOT . '/libraries/models/notificationsmodel.php');

//On vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    addFlash('error', 'Vous devez d\'abord vous connecter');
    header("Location: connexion.php");
    exit();
};

if (!empty($_POST)) {

    //Si les champs sont remplis
    if (
        isset($_POST['mail']) && isset($_POST['ville'])
        && !empty($_POST['mail'] && !empty($_POST['ville']))
    ) {

        require(ROOT . '/libraries/models/usermodel.php');

        //On défini les variables
        $mail = htmlspecialchars($_POST['mail']);
        $ville = htmlspecialchars($_POST['ville']);
        $userId = $_SESSION['user']['id'];

        //On récupère immédiatement les infos de la BDD pour les stocker en $_SESSION 
        $user = getUserFromId($pdo, $userId);

        //On update à la BDD
        updateUser($pdo, $mail, $ville, $userId);

        //on stocke les nouvelles infos dans $_SESSION
        $_SESSION['user'] = [
            'id' => intVal($userId),
            'mail' => htmlspecialchars($_POST["mail"]),
            'ville' => htmlspecialchars($_POST["ville"]),
            'pseudo' => htmlspecialchars($_SESSION['user']['pseudo']),
            'role' => intVal($user['role'])
        ];      

        //on redirige vers la page de profil
        addFlash('success', 'La demande de modification est bien prise en compte');
        header("Location: profil");
        exit();
    }
}
$template = 'editprofil.phtml';

require('views/layout.phtml');
