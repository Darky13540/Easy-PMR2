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

if (isset($_POST['name'])) {
    $poi = getPoiBySearch($pdo, $_POST['name']);
} else {
    $poi = getAllPoi($pdo);
}

$count = count($poi);

$template = 'poiadmin.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');
