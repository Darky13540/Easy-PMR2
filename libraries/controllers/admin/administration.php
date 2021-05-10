<?php
require(ROOT . 'libraries/models/notificationsmodel.php');

//On teste si l'utilisateur est admin
if (isset($_SESSION)) {

    //Si non admin->redirection
    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

$template = 'administration.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');
