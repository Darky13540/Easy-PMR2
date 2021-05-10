<?php

/* Construction d'un objet PDO représentant la connexion à une BDD*/

const DBNAME = 'darky13540_easy-pmr';
const HOST = 'mysql-darky13540.alwaysdata.net';
const LOGIN = '229228';
const PASSWORD = 'Azertyuiop1#';

//Définition de  $pdo comme nouvelle instance de PDO
$pdo = new PDO(
   'mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=UTF8',
   LOGIN,
   PASSWORD
);

