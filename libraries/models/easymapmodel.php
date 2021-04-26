<?php

require 'bdconnect.php';
/**
 * Permet de récupérer tous les POI dans la BDD
 *
 * @param PDO $pdo
 * @return array
 */
function getAllPoi(PDO $pdo)
{
    $reponse = $pdo->query('SELECT * FROM shop');
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $poi;
}

/**
 * Permet de récupérer les POI par nom
 *
 * @param PDO $pdo
 * @param string $name
 * @return array
 */
function getPoiByName(PDO $pdo, string $name)
{
    $reponse = $pdo->prepare('SELECT * FROM shop WHERE name LIKE ?');
    $reponse->execute(['%' .$name. '%']);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $poi;
}

/**
 * Permet de récupérer les POI par type
 *
 * @param PDO $pdo
 * @param string $type
 * @return array
 */
function getPoiByType(PDO $pdo, string $type)
{
    $reponse = $pdo->prepare("SELECT * FROM shop WHERE type LIKE ?");
    $reponse->execute(['%' .$type. '%']);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $poi;
}

/**
 * Permet de récupérer les POI par type ET nom
 *
 * @param PDO $pdo
 * @param string $type
 * @param string $name
 * @return array
 */
function getPoiByTypeName(PDO $pdo, string $type, string $name)
{
    $reponse = $pdo->prepare("SELECT * FROM shop WHERE type LIKE ? AND name LIKE ?");
    $reponse->execute(['%' .$type. '%', '%' .$name. '%']);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $poi;
}

/**
 * Permet de récupérer le POI concerné
 *
 * @param PDO $pdo
 * @param string $id
 * @return array
 */
function getPoiById(PDO $pdo, string $id)
{
    $reponse = $pdo->prepare("SELECT name FROM shop WHERE id= :id");
    $reponse->execute([':id' => $id]);
    $details = $reponse->fetch(PDO::FETCH_ASSOC);
    return $details;
}
