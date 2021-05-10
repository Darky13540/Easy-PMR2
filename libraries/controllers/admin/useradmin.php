<?php
require(ROOT . 'libraries/models/notificationsmodel.php');
require(ROOT . 'libraries/models/usermodel.php');

//On teste si le'utilisateur est un visiteur
if (isset($_SESSION)) {

    //Non admin->redirection
    if ($_SESSION['user']['role'] != 1) {
        addFlash('error', 'Vous ne disposez pas des droits nécessaires');
        header("Location: connexion");
        exit();
    }
}

//Si la saisie de recherche est vide on récupère tous les users de la BDD
if (empty($_POST['pseudo'])) {

    $users = getAllUsers($pdo);

    //Sinon on récupère le résultat de la recherche
} else {
    $users = getUserFromPseudo($pdo, $_POST['pseudo']);
};

//On compte le nb de retours pour affichage
$count = count($users);

$template = 'useradmin.phtml';

require(ROOT . 'views/admin/layoutadmin.phtml');
