<?php
require(ROOT . '/libraries/models/easymapmodel.php');

if (empty($_GET['id'])) {
    //rediriger vers la page index.php
    header('Location: easymap');
    exit();
}


$details = getPoiById($pdo, $_GET['id']);

if($details === false){
    header('Location: easymap');
    exit();
}

$template = 'details.phtml';

require(ROOT . '/views/layout.phtml');
