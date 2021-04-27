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
if (empty($_POST['pseudo'])) {
    $users = getAllUsers($pdo);
} else {
    $users = getUserFromPseudo($pdo, $_POST['pseudo']);
};
$count = count($users);
$template = 'useradmin.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');
