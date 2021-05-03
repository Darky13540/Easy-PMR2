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

$template = 'categoriesadmin.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');