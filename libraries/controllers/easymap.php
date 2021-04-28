<?php
require (ROOT .'/libraries/models/easymapmodel.php');

if (empty($_POST['type']) && empty($_POST['name'])){
    
    /* recherche globale */
    $poi = getAllPoi($pdo);
    
}elseif (empty($_POST['type']) && !empty($_POST['name'])){

    /* recherche par nom */
    $poi = getPoiByName($pdo, $_POST['name']);

}elseif (!empty($_POST['type']) && empty($_POST['name'])){
    
    /* recherche par type */
    $poi = getPoiByType($pdo, $_POST['type']);
    

    
}elseif (!empty($_POST['type']) && !empty($_POST['name'])){
    /* recherche par nom ET type*/
    $poi = getPoiByTypeName($pdo, $_POST['type'], $_POST['name']);
};
$genres = getGenre($pdo);
$types = getTypes($pdo);
$count = count($poi);

$template = 'easymap.phtml';

require (ROOT.'/views/layout.phtml');

