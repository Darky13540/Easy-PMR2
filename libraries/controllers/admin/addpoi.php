<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/easymapmodel.php');

//on teste si l'utilisateur est un visiteur, si oui redirection
if (isset($_SESSION)) {

    //si l'utilisateur est un user->redirection
    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

//Appelle des différents types et genres
$types = getTypes($pdo);
$genres = getGenre($pdo);

//on vérifie que les chaps nécessaires sont remplis
if (isset(
    $_POST['name']) 
    && isset($_POST['longitude']) 
    && isset($_POST['latitude']) 
    && isset($_POST['genre']) 
    && isset($_POST['type']) 
    && isset($_POST['adresse']) 
    && isset($_POST['cp']) 
    && isset($_POST['commune']) 
    && isset($_POST['opening']) 
    && isset($_POST['phone']) 
    && isset($_POST['website'])){

        //si oui on insère le lieu dans la BDD
        insertPoi($pdo, $_POST['name'], 
                        $_POST['latitude'], 
                        $_POST['longitude'], 
                        $_POST['genre'], 
                        $_POST['type'], 
                        $_POST['adresse'], 
                        $_POST['cp'], 
                        $_POST['commune'], 
                        $_POST['opening'],
                        $_POST['phone'], 
                        $_POST['website']);   
                
            //Notification de succés et redirection
            addFlash('success', 'Lieu ajouté !');
            header('Location: poiadmin');
            exit();
}

$template = 'addpoi.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');

