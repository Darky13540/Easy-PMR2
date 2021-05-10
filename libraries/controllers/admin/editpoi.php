<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/easymapmodel.php');

//ON teste si l'utiliateur est un visiteur
if (isset($_SESSION)) {
    //Pas admin->redirection
    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

//On appelle les résultats pour un lieu donné
$shop = getPoiById($pdo, $_GET['id']);
$types = getTypes($pdo);
$genres = getGenre($pdo);

$template = 'editpoi.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');


