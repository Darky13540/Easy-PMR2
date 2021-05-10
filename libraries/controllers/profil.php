<?php

require(ROOT . '/libraries/models/notificationsmodel.php');

//On vérifie si le user est bien inscrit sinon redirection
if (!isset($_SESSION['user'])) {
    addFlash('error', 'Connectez vous pour accéder à la page');
    header("Location: connexion");
    exit();
}

$template = 'profil.phtml';

require('views/layout.phtml');
