<?php


require(ROOT . '/libraries/models/easymapmodel.php');
require(ROOT . '/libraries/models/tagsmodel.php');
require(ROOT . '/libraries/models/notificationsmodel.php');

//Teste si Id existe
if (empty($_GET['id'])) {
    //rediriger vers la page index.php
    header('Location: easymap');
    exit();
}

//On appelle la BDD pour les infos (détails, tags, rating, lastContributeur)
$details = getPoiById($pdo, $_GET['id']);
$tagsById = getTagsByShopId($pdo, intval($_GET['id']));
$rating = getRatingById($pdo, $_GET['id']);
$lastContributeur = getLastContributeur($pdo, $_GET['id']);

//On teste si l'utilisateur a déjà laissé un avis sur le lieu
if(!empty($_SESSION['user'])){

    //On vérifie dans ratings si le coule user/lieu existe
    $alreadyRate = userHasAlreadyRate($pdo, $_SESSION['user']['id'], intval($_GET['id']),);
}else{
    $alreadyRate = false;
}

//Pour éviter que l'user rentre des id au hasard, si l'id n'existe pas il y a une redirection
if($details === false){
    header('Location: easymap');
    exit();
}

$template = 'details.phtml';

require(ROOT . '/views/layout.phtml');
