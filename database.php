<?php

/* Connexion à une base MySQL*/

$dbName = 'darky13540_easy-pmr';
$dbHost = 'mysql-darky13540.alwaysdata.net';
$user = '229228';
$password = 'Azertyuiop1#';

try {
$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $user, $password);

} catch (PDOException $e) {
print "Erreur !: " . $e->getMessage() . "<br/>";
die();
}
return $pdo;