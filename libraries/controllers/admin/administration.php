<?php
require(ROOT.'notifications.php');

if (isset($_SESSION)) {

    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

$template = 'administration.phtml';
require(ROOT.'views/admin/layoutadmin.phtml');
