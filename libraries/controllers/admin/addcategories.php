<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/easymapmodel.php');

//On teste si l'utilisateur est un admin sinon redirection
if (isset($_SESSION)) {

    //si pas admin->redirection
    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

//On teste si le type est vide
if (!empty($_POST['newType'])){

    //Non vide on l'ajoute à la BDD
    addType($pdo, ucFirst($_POST['newType']));
    addFlash('success','L\'ajout est bien pris en compte');
    header('Location: categoriesadmin');
    exit();

//SI Type est vide on teste genre
}elseif(!empty($_POST['newGenre'])){

    //Non vide on l'ajoute à la BDD
    addGenre($pdo, ucFirst($_POST['newGenre']));
    addFlash('success','L\'ajout est bien pris en compte');
    header('Location: categoriesadmin');
    exit();
}

$template = 'addcategories.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');