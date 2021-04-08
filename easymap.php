<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require ('bdconnect.php');

    /* global */
        $reponse = $pdo->query('SELECT * FROM shop');
        $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);


    /* par type */
 /* $reponse = $pdo->prepare("SELECT * FROM shop WHERE type= :type");
    $reponse->execute(['type' => $_POST['type']]);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
var_dump($poi); */

    /* par nom */
 /* $reponse = $pdo->prepare("SELECT * FROM shop WHERE name= :name");
    $reponse->execute(['name' => $_POST['name']]);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
   $_POST['type']="";
    $_POST['name']="";
var_dump($poi); */

require ('Views/easymap.phtml');
?>


