<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/easymapmodel.php');

//On vérifie si l'utilisateur est un visiteur
if (isset($_SESSION)) {

    //Pas admin->redirection
    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

//On teste l'ID est renseigné
if(!isset($_GET['id'])){
    addFlash('error', 'l\'id du magasin n\'est pas précisé');
    header("Location: poiadmin");
    exit();
}

//Affichage du genre sélectionné
$genre = getGenreById($pdo, $_GET['id']);

//S'il n'existe pas on redirige
if($genre === false){
    header('Location: easymap');
    exit();
}

//On recherche si il y a des lieux avec ce genre
$poigenre = getPoiByGenre($pdo, $_GET['id']);

//Si bouton delete cliqué et alert validée on supprime de la BDD puis notification et redirection
if (isset($_POST['deleteGenre'])) {
    deleteGenre($pdo, $_GET['id']);
    addFlash('success', 'La suppression a bien été faite');
    header('Location: categoriesadmin');
    exit();
}

//Si bouton edit cliqué et alert on édite le genre en BDD puis notification et redirection
if(isset($_POST['editedGenre'])){
    editGenre($pdo, ucFirst($_POST['editedGenre']), $_GET['id']);
    addFlash('success','Modification faite!');
    header('Location: categoriesadmin');
    exit();
}

$template = 'editgenre.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');