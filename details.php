<?php
if (empty($_GET['id'])) {
    //rediriger vers la page index.php
    header('Location: easymap.php');
    exit();
}


//connexion bdd
require 'bdconnect.php';


$reponse = $pdo->prepare('SELECT * FROM shop WHERE idi= ?');
$reponse->execute([$_GET['id']]);
$details = $reponse->fetch(PDO::FETCH_ASSOC);

/* var_dump($_GET['id']);
var_dump($details); */
require ('views/details.phtml');