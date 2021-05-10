<?php
require(ROOT . '/libraries/models/notificationsmodel.php');
require(ROOT . '/libraries/models/easymapmodel.php');
require(ROOT . '/libraries/models/tagsmodel.php');

//On vérifie que le user est connecté pour pouvoir participer
if (!isset($_SESSION['user'])) {
    addFlash('error', 'Vous devez d\'abord vous connecter');
    header("Location: connexion.php");
    exit();
};

//On récupère en BDD les infos générales du lieu
$details = getPoiById($pdo, intval($_GET['id']));

//Si pas de retour le lieu n'est pas en BDD on redirige
if($details === false){
    header('Location: easymap');
    exit();
}

//On appelle toutes les infos des tags en BDD
$tagsById = getTagsByShopId($pdo, intval($_GET['id']));
$tagsPark = getParkTags($pdo);
$tagsEntree = getEntreeTags($pdo);
$tagsPorte = getPorteTags($pdo);
$tagsBat = getBatimentTags($pdo);
$tagsInt = getIntTags($pdo);
$tagsService = getServiceTags($pdo);
$tagsToilettes = getToilettesTags($pdo);

//On insère en BDD les infos récupérées avec les select
if(!empty($_POST)){
    updatePoiTags($pdo, $_POST['park'], $_POST['entree'], $_POST['porte'], 
                    $_POST['interieur'], $_POST['batiment'], $_POST['toilettes'], 
                    $_POST['service'], $_GET['id']);
    
    //On insère la note associée au user et au lieu, notification et redirection vers le lieu
    insertRating($pdo, $_POST['rating'], $_GET['id'], $_SESSION['user']['id']);              
    addFlash('success','Merci pour votre participation !!') ;   
    header('Location: details?id='.$_GET['id']);
    exit();
}



$template = 'updatetags.phtml';

require(ROOT . '/views/layout.phtml');
