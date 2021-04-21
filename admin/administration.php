<?php
require('../notifications.php');
session_start();

if (isset($_SESSION)) {

    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: ../connexion.php");
        exit();
    }
}
require('../views/admin/administration.phtml');
