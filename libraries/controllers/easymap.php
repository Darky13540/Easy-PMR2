<?php
require(ROOT . '/libraries/models/easymapmodel.php');


//On vérifie si la recherche est vide
if (!isset($_POST['query']) && empty($_POST['query'])) {

    //Si elle est vide on appelle tous les lieux en BDD
    $poi = getAllPoi($pdo);

} else {

    //Sinon on affiche le résultat de la recherche
    $poi = getPoiBySearch($pdo, $_POST['query']);
    
}

//Appelle des genres et des types
$genres = getGenre($pdo);
$types = getTypes($pdo);
$count = count($poi);

$template = 'easymap.phtml';

require(ROOT . '/views/layout.phtml');
