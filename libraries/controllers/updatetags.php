<?php
require(ROOT . '/libraries/models/notificationsmodel.php');
require(ROOT . '/libraries/models/easymapmodel.php');
require(ROOT . '/libraries/models/tagsmodel.php');

if (!isset($_SESSION['user'])) {
    addFlash('error', 'Vous devez d\'abord vous connecter');
    header("Location: connexion.php");
    exit();
};
$details = getPoiById($pdo, intval($_GET['id']));

if($details === false){
    header('Location: easymap');
    exit();
}
$tagsById = getTagsByShopId($pdo, intval($_GET['id']));
$tagsPark = getParkTags($pdo);
$tagsEntree = getEntreeTags($pdo);
$tagsPorte = getPorteTags($pdo);
$tagsBat = getBatimentTags($pdo);
$tagsInt = getIntTags($pdo);
$tagsService = getServiceTags($pdo);
$tagsToilettes = getToilettesTags($pdo);

if(!empty($_POST)){
    updatePoiTags($pdo, $_POST['park'], $_POST['entree'], $_POST['porte'], 
                    $_POST['interieur'], $_POST['batiment'], $_POST['toilettes'], 
                    $_POST['service'], $_GET['id'], $_SESSION['user']['id']);
    
    
    insertRating($pdo, $_POST['rating'], $_GET['id'], $_SESSION['user']['id']);              
    addFlash('success','Merci pour votre participation !!') ;   
    header('Location: details?id='.$_GET['id']);
    exit();
}



$template = 'updatetags.phtml';

require(ROOT . '/views/layout.phtml');
