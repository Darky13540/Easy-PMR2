<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/easymapmodel.php');

//On teste si l'utilisateur est admin
if (isset($_SESSION)) {

    //Non admin ->redirection
    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

//Appelle des types et genres de la BDD
$types = getTypes($pdo);
$genres = getGenre($pdo);

$template = 'categoriesadmin.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');