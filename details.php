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


require ('views/details.phtml');