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
    $reponse = $pdo->query('
    SELECT * , shops.id AS shopId
    FROM shops 
    INNER JOIN types ON types.id = shops.typeId
    INNER JOIN genres ON genres.id = shops.genreId');
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $poi;
}

/**
 * Permet de récupérer les POI avec une recherche partielle
 * sur nom, type ou genre
 * @param PDO $pdo
 * @param string $query
 * @return array
 */
function getPoiBySearch(PDO $pdo, string $query)
{
    $reponse = $pdo->prepare('
    SELECT * , shops.id AS shopId
    FROM shops 
    INNER JOIN types ON types.id = shops.typeId
    INNER JOIN genres ON genres.id = shops.genreId 
    WHERE name LIKE ? OR type LIKE ? OR genre LIKE ?');
    $reponse->execute(['%' .$query. '%','%' .$query. '%','%' .$query. '%']);
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
    $reponse = $pdo->prepare('
    SELECT * 
    FROM shops 
    INNER JOIN types ON types.id = shops.typeId
    INNER JOIN genres ON genres.id = shops.genreId 
    WHERE name LIKE ?');
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
    $reponse = $pdo->prepare("
    SELECT * 
    FROM shops 
    INNER JOIN types ON types.id = shops.typeId 
    INNER JOIN genres ON genres.id = shops.genreId
    WHERE type LIKE ?");
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
    $reponse = $pdo->prepare("
    SELECT * 
    FROM shops 
    INNER JOIN types ON types.id = shops.typeId 
    INNER JOIN genres ON genres.id = shops.genreId
    WHERE type LIKE ? AND name LIKE ?");
    $reponse->execute(['%' .$type. '%', '%' .$name. '%']);
    $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $poi;
}

/**
 * Permet de récupérer le POI concerné grâce à son id
 *
 * @param PDO $pdo
 * @param string $id
 * @return array
 */
function getPoiById(PDO $pdo, string $id)
{
    $reponse = $pdo->prepare("
    SELECT * , shops.id AS shopId
    FROM shops 
    INNER JOIN types ON types.id = shops.typeId
    INNER JOIN genres ON genres.id = shops.genreId
    WHERE shops.id= :id");
    $reponse->execute([':id' => $id]);
    $details = $reponse->fetch(PDO::FETCH_ASSOC);
    return $details;
}

/**
 * Permet de récupérer la liste des types
 *
 * @param PDO $pdo
 * @return array
 */
function getTypes(PDO $pdo){
    $reponse = $pdo->prepare("
    SELECT type 
    FROM types"); 
    $reponse->execute();
    $types = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $types;
}

/**
 * Permet de récupérer la liste des genres
 *
 * @param PDO $pdo
 * @return array
 */
function getGenre(PDO $pdo){
    $reponse = $pdo->prepare("
    SELECT genre 
    FROM genres"); 
    $reponse->execute();
    $genres = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $genres;
}

