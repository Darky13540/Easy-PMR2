<?php
require(ROOT . '/libraries/models/easymapmodel.php');

if (!isset($_POST['query']) && empty($_POST['query'])) {

    $poi = getAllPoi($pdo);
} else {

    $poi = getPoiBySearch($pdo, $_POST['query']);
}


$genres = getGenre($pdo);
$types = getTypes($pdo);
$count = count($poi);

$template = 'easymap.phtml';

require(ROOT . '/views/layout.phtml');
