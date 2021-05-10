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


$types = getTypes($pdo);
$genres = getGenre($pdo);
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

        


            addFlash('success', 'Lieu ajouté !');
            header('Location: poiadmin');
            exit();
}

$template = 'addpoi.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');

