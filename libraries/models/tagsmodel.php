<?php
/**
 * Permet de récupérer les tags associés à un lieu
 *
 * @param PDO $pdo
 * @param integer $id
 * @return array
 */
function getTagsByShopId(PDO $pdo, int $id)
{
    $reponse = $pdo->prepare("
    SELECT shops.id AS shopId, tagsParkId, tagsEntreeId,
    tagsPorteId, tagsIntId, tagsBatimentId, tagsToilettesId,
    tagsServiceId, genreId, typeId, lastUpdate 
    FROM shops 
    INNER JOIN tagsPark ON tagsPark.id = shops.tagsParkId
    INNER JOIN tagsEntree ON tagsEntree.id = shops.tagsEntreeId
    INNER JOIN tagsPorte ON tagsPorte.id = shops.tagsPorteId
    INNER JOIN tagsInt ON tagsInt.id = shops.tagsIntId
    INNER JOIN tagsBatiment ON tagsBatiment.id = shops.tagsBatimentId
    INNER JOIN tagsToilettes ON tagsToilettes.id = shops.tagsToilettesId
    INNER JOIN tagsService ON tagsService.id = shops.tagsServiceId
    WHERE shops.id= ?");
    $reponse->execute([$id]);
    $tagsById = $reponse->fetch(PDO::FETCH_ASSOC);
    return $tagsById;
}

/**
 * Permet de récupérer la liste des tags du batiment
 *
 * @param PDO $pdo
 * @return array
 */
function getBatimentTags(PDO $pdo)
{
    $reponse = $pdo->prepare("
    SELECT *
    FROM tagsBatiment");
    $reponse->execute();
    $tagsBat = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $tagsBat;
}

/**
 * Permet de récupérer la liste des tags de l'entrée
 *
 * @param PDO $pdo
 * @return array
 */
function getEntreeTags(PDO $pdo)
{
    $reponse = $pdo->prepare("
    SELECT *
    FROM tagsEntree");
    $reponse->execute();
    $tagsEntree = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $tagsEntree;
}

/**
 * Permet de récupérer la liste des tags de l'intérieur
 *
 * @param PDO $pdo
 * @return array
 */
function getIntTags(PDO $pdo)
{
    $reponse = $pdo->prepare("
    SELECT *
    FROM tagsInt");
    $reponse->execute();
    $tagsInt = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $tagsInt;
}

/**
 * Permet de récupérer la liste des tags du stationnement
 *
 * @param PDO $pdo
 * @return array
 */
function getParkTags(PDO $pdo)
{
    $reponse = $pdo->prepare("
    SELECT *
    FROM tagsPark");
    $reponse->execute();
    $tagsPark = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $tagsPark;
}

/**
 * Permet de récupérer la liste des tags de la porte
 *
 * @param PDO $pdo
 * @return array
 */
function getPorteTags(PDO $pdo)
{
    $reponse = $pdo->prepare("
    SELECT *
    FROM tagsPorte");
    $reponse->execute();
    $tagsPorte = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $tagsPorte;
}

/**
 * Permet de récupérer la liste des tags des services
 *
 * @param PDO $pdo
 * @return array
 */
function getServiceTags(PDO $pdo)
{
    $reponse = $pdo->prepare("
    SELECT *
    FROM tagsService");
    $reponse->execute();
    $tagsService = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $tagsService;
}

/**
 * Permet de récupérer la liste des tags pour les toilettes
 *
 * @param PDO $pdo
 * @return array
 */
function getToilettesTags(PDO $pdo)
{
    $reponse = $pdo->prepare("
    SELECT *
    FROM tagsToilettes");
    $reponse->execute();
    $tagsToilettes = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $tagsToilettes;
}