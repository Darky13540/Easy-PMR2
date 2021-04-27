<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/usermodel.php');

if (isset($_SESSION)) {

    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

//Si le role est défini en $_POST on traite la modification du statut
if (isset($_POST['role']) && in_array($_POST['role'], ["1", "0"])) {


    $user = changeRole($pdo, $_GET['id'], $_POST['role']);
}

if (isset($_POST['delete'])) {
    deleteUser($pdo, $_GET['id']);
    addFlash('succes', 'La suppression a bien été faite');
    header('Location: useradmin');
    exit();
}


$user = getUserFromId($pdo, $_GET['id']);

$template = 'edituser.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');
