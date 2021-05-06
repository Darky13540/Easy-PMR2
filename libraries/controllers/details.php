<?php
require(ROOT . '/libraries/models/easymapmodel.php');
require(ROOT . '/libraries/models/tagsmodel.php');

if (empty($_GET['id'])) {
    //rediriger vers la page index.php
    header('Location: easymap');
    exit();
}

/* var_dump($_GET); */
$details = getPoiById($pdo, $_GET['id']);
$tagsById = getTagsByShopId($pdo, $_GET['id']);

/* var_dump($tagsById);
var_dump($details);
die(); */


if($details === false){
    header('Location: easymap');
    exit();
}

$template = 'details.phtml';

require(ROOT . '/views/layout.phtml');
