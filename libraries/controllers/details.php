<?php
require(ROOT . '/libraries/models/easymapmodel.php');
require(ROOT . '/libraries/models/tagsmodel.php');

if (empty($_GET['id'])) {
    //rediriger vers la page index.php
    header('Location: easymap');
    exit();
}


$details = getPoiById($pdo, $_GET['id']);
$tagsById = getTagsByShopId($pdo, $_GET['id']);
$tagsBat = getBatimentTags($pdo);

if($details === false){
    header('Location: easymap');
    exit();
}

$template = 'details.phtml';

require(ROOT . '/views/layout.phtml');
