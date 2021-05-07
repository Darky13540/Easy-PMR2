<?php


require(ROOT . '/libraries/models/easymapmodel.php');
require(ROOT . '/libraries/models/tagsmodel.php');
require(ROOT . '/libraries/models/notificationsmodel.php');

if (empty($_GET['id'])) {
    //rediriger vers la page index.php
    header('Location: easymap');
    exit();
}

/* var_dump($_GET); */
$details = getPoiById($pdo, $_GET['id']);
$tagsById = getTagsByShopId($pdo, intval($_GET['id']));
$rating = getRatingById($pdo, $_GET['id']);
$alreadyRate = userHasAlreadyRate($pdo, $_SESSION['user']['id'], intval($_GET['id']),);

if($details === false){
    header('Location: easymap');
    exit();
}

$template = 'details.phtml';

require(ROOT . '/views/layout.phtml');
