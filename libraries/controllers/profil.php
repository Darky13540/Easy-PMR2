<?php

require(ROOT . '/libraries/models/notificationsmodel.php');
if (!isset($_SESSION['user'])) {
    addFlash('error', 'Connectez vous pour accéder à la page');
    header("Location: connexion");
    exit();
}

$template = 'profil.phtml';

require('views/layout.phtml');
