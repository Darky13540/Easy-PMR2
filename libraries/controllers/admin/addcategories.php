<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/easymapmodel.php');

if (isset($_SESSION)) {

    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

if (!empty($_POST['newType'])){

    addType($pdo, ucFirst($_POST['newType']));
    addFlash('success','L\'ajout est bien pris en compte');
    header('Location: categoriesadmin');
    exit();

}elseif(!empty($_POST['newGenre'])){

    addGenre($pdo, ucFirst($_POST['newGenre']));
    addFlash('success','L\'ajout est bien pris en compte');
    header('Location: categoriesadmin');
    exit();
}

$template = 'addcategories.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');