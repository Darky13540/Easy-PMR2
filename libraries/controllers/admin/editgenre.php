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

$genre = getGenreById($pdo, $_GET['id']);

if (isset($_POST['deleteGenre'])) {
    deleteGenre($pdo, $_GET['id']);
    addFlash('success', 'La suppression a bien été faite');
    header('Location: categoriesadmin');
    exit();
}

if(isset($_POST['editedGenre'])){
    editGenre($pdo, $_POST['editedGenre'], $_GET['id']);
    addFlash('success','Modification faite!');
    header('Location: categoriesadmin');
    exit();
}

$template = 'editgenre.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');