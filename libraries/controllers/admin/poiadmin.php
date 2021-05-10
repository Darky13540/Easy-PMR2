<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/easymapmodel.php');

//On test si l'utilisateur est un visiteur
if (isset($_SESSION)) {

    //Non admin->redirection
    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

//On recherche dans type, genre, nom la requête saisie
if (isset($_POST['name'])) {

    //On récupère les infos
    $poi = getPoiBySearch($pdo, $_POST['name']);

    //Sinon on récupère tous les lieux
} else {
    $poi = getAllPoi($pdo);
}

//On compte l nb de retours pour affichage dans la view
$count = count($poi);

$template = 'poiadmin.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');
