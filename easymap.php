<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

session_start();
require ('bdconnect.php');
if (empty($_POST['type']) && empty($_POST['name'])){
    
    /* recherche globale */
    $reponse = $pdo->query('SELECT * FROM shop');
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    
}elseif (empty($_POST['type']) && !empty($_POST['name'])){

    /* recherche par nom */
    $reponse = $pdo->prepare("SELECT * FROM shop WHERE name= :name");
    $reponse->execute([':name' => htmlspecialchars($_POST['name'])]);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    $_POST['name']="";

}elseif (!empty($_POST['type']) && empty($_POST['name'])){
    
    /* recherche par type */
    $reponse = $pdo->prepare("SELECT * FROM shop WHERE type= :type");
    $reponse->execute([':type' => htmlspecialchars($_POST['type'])]);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    $_POST['type']="";

}elseif (!empty($_POST['type']) && !empty($_POST['name'])){
    /* recherche par nom ET type*/
    $reponse = $pdo->prepare("SELECT * FROM shop WHERE type= :type AND name= :name");
    $reponse->execute([':type' => htmlspecialchars($_POST['type']), ':name' => htmlspecialchars($_POST['name'])]);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    $_POST['name']="";
    $_POST['type']="";
    
}
$count = count($poi);


require ('views/easymap.phtml');
