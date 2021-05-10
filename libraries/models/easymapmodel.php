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
 * @param integer $typeid
 * @return array
 */
function getPoiByType(PDO $pdo, int $typeid)
{
    $reponse = $pdo->prepare("
    SELECT * 
    FROM shops 
    INNER JOIN types ON types.id = shops.typeId 
    INNER JOIN genres ON genres.id = shops.genreId
    WHERE typeId = ?");
    $reponse->execute([$typeid]);
    $poitype = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $poitype;
}

/**
 * Permet de récupérer les POI par genre
 *
 * @param PDO $pdo
 * @param integer $typeid
 * @return array
 */
function getPoiByGenre(PDO $pdo, int $typeid)
{
    $reponse = $pdo->prepare("
    SELECT * 
    FROM shops 
    INNER JOIN types ON types.id = shops.typeId 
    INNER JOIN genres ON genres.id = shops.genreId
    WHERE genreId = ?");
    $reponse->execute([$typeid]);
    $poigenre = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $poigenre;
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
    INNER JOIN tagsPark ON tagsPark.id = shops.tagsParkId
    INNER JOIN tagsEntree ON tagsEntree.id = shops.tagsEntreeId
    INNER JOIN tagsPorte ON tagsPorte.id = shops.tagsPorteId
    INNER JOIN tagsInt ON tagsInt.id = shops.tagsIntId
    INNER JOIN tagsBatiment ON tagsBatiment.id = shops.tagsBatimentId
    INNER JOIN tagsToilettes ON tagsToilettes.id = shops.tagsToilettesId
    INNER JOIN tagsService ON tagsService.id = shops.tagsServiceId
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
    SELECT type, id 
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
    SELECT genre, id 
    FROM genres"); 
    $reponse->execute();
    $genres = $reponse->fetchAll(PDO::FETCH_ASSOC);
    return $genres;
}

/**
 * Permet d'éditer un POI
 *
 * @param PDO $pdo
 * @param string $name
 * @param float $latitude
 * @param float $longitude
 * @param int $genre
 * @param int $type
 * @param string $adresse
 * @param integer $cp
 * @param string $commune
 * @param string $opening
 * @param string $phone
 * @param string $website
 * @param int $id
 * @return void
 */
function editPoi(
    PDO $pdo, string $name, 
    float $latitude, float $longitude, 
    int $genre, int $type, 
    string $adresse, int $cp, 
    string $commune, string $opening, 
    string $phone, string $website, int $id){

    //prepare la requête
    $query = $pdo->prepare('
    UPDATE shops 
    SET name = ? , 
    lat = ? ,
    longitude = ? ,
    genreId = ? ,
    typeId = ? ,
    shops.adresse = ? ,
    cp = ? ,
    commune = ? ,
    opening = ? ,
    phone = ? ,
    website = ?  
    WHERE id = ? ');

    //execute la requête
    $query->execute([
    $name, floatval($latitude),
    floatval($longitude), $genre,
    $type, 
    $adresse, $cp, 
    $commune, $opening, 
    $phone, $website, intval($id)]);   
}

/**
 * Permet d'insérer un lieu
 *
 * @param PDO $pdo
 * @param string $name
 * @param float $latitude
 * @param float $longitude
 * @param int $genre
 * @param int $type
 * @param string $adresse
 * @param integer $cp
 * @param string $commune
 * @param string $opening
 * @param string $phone
 * @param string $website
 * @return void
 */
function insertPoi(
PDO $pdo, string $name, 
float $latitude, float $longitude, 
int $genre, int $type, 
string $adresse, int $cp, 
string $commune, string $opening, 
string $phone, string $website)
{
    //preparer la requête
    $query = $pdo->prepare('
    INSERT INTO shops 
    (name, lat, longitude, genreId, typeId, adresse, cp, commune, opening, phone, website) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

    //executer la requête
    $query->execute([
        $name, floatval($latitude),
        floatval($longitude), $genre,
        $type, 
        $adresse, $cp, 
        $commune, $opening, 
        $phone, $website]);

    $pdo->lastInsertId();

    return $query->fetch(PDO::FETCH_ASSOC);
}


/**
 * Permet d'effacer un POI de la BDD
 *
 * @param PDO $pdo
 * @param [type] $id
 * @return void
 */
function deletePoi(PDO $pdo, $id){
    
    //prepare la requête
    $query = $pdo->prepare('
    DELETE FROM shops 
    WHERE id = ? LIMIT 1');
    //execute la requête
    $query->execute([$id]);

    $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet d'ajouter un type en BDD
 *
 * @param PDO $pdo
 * @param string $type
 * @return void
 */
function addType(PDO $pdo, string $type){
    //preparer la requête
    $query = $pdo->prepare('
    INSERT INTO types 
    (type) 
    VALUES (?)');

    //executer la requête
    $query->execute([$type]);
}

/**
 * Permet d'ajouter un genre en BDD
 *
 * @param PDO $pdo
 * @param string $genre
 * @return void
 */
function addGenre(PDO $pdo, string $genre){
    //preparer la requête
    $query = $pdo->prepare('
    INSERT INTO genres 
    (genre) 
    VALUES (?)');

    //executer la requête
    $query->execute([$genre]);
}

/**
 * Permet de modifier un genre
 *
 * @param PDO $pdo
 * @param string $genre
 * @param integer $id
 * @return void
 */
function editGenre(PDO $pdo, string $genre, int $id){
    //prepare la requête
    $query = $pdo->prepare('
    UPDATE genres 
    SET genre = ?      
    WHERE id = ? ');

    //execute la requête
    $query->execute([$genre, $id]);
}

/**
 * Permet de modifier un type
 *
 * @param PDO $pdo
 * @param string $type
 * @param integer $id
 * @return void
 */
function editType(PDO $pdo, string $type, int $id){
    //prepare la requête
    $query = $pdo->prepare('
    UPDATE types 
    SET type = ?      
    WHERE id = ? ');

    //execute la requête
    $query->execute([$type, $id]);
}

/**
 * Permet d'avoir les infos du type par son Id
 *
 * @param PDO $pdo
 * @param integer $id
 * @return void
 */
function getGenreById(PDO $pdo, int $id){
    //prepare la requête
    $reponse = $pdo->prepare("
    SELECT genre, id 
    FROM genres
    WHERE id=?"); 

    //execute la requête
    $reponse->execute([$id]);
    $genre = $reponse->fetch(PDO::FETCH_ASSOC);
    return $genre;
}

/**
 * Permet d'avoir les infos du genre par son Id
 *
 * @param PDO $pdo
 * @param integer $id
 * @return void
 */
function getTypeById(PDO $pdo, int $id){
    //prepare la requête
    $reponse = $pdo->prepare("
    SELECT type, id 
    FROM types
    WHERE id=?"); 

    //execute la requête
    $reponse->execute([$id]);
    $type = $reponse->fetch(PDO::FETCH_ASSOC);
    return $type;
}

/**
 * Permet de supprimer un type de la BDD
 *
 * @param PDO $pdo
 * @param integer $id
 * @return void
 */
function deleteType(PDO $pdo, int $id){
    //prepare la requête
    $query = $pdo->prepare('
    DELETE FROM types 
    WHERE id = ? LIMIT 1');
    //execute la requête
    $query->execute([$id]);

    $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet de supprimer un genre de la BDD
 *
 * @param PDO $pdo
 * @param integer $id
 * @return void
 */
function deleteGenre(PDO $pdo, int $id){
    //prepare la requête
    $query = $pdo->prepare('
    DELETE FROM genres 
    WHERE id = ? LIMIT 1');
    //execute la requête
    $query->execute([$id]);

    $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet de mettre à jour les tags dans shops
 *
 * @param PDO $pdo
 * @param integer $park
 * @param integer $entree
 * @param integer $porte
 * @param integer $batiment
 * @param integer $interieur
 * @param integer $service
 * @param integer $toilettes
 * @param integer $id
 * @param integer $userId
 * @return void
 */
function updatePoiTags(PDO $pdo, int $park, int $entree, 
                        int $porte, int $batiment, 
                        int $interieur, int $service, 
                        int $toilettes, int $id)
{
    //prepare la requête
    $query = $pdo->prepare('
    UPDATE shops 
    SET tagsParkId = ? , 
    tagsEntreeId = ? ,
    tagsPorteId = ? ,
    tagsIntId = ? ,
    tagsBatimentId = ? ,
    tagsToilettesId = ? ,
    tagsServiceId = ? , 
    lastUpdate = NOW()   
    WHERE id = ? ');

    //execute la requête
    $query->execute([intval($park), intval($entree), intval($porte), intval($batiment),
                    intval($interieur), intval($service), intval($toilettes), 
                    intval($id)]);
}

/**
 * Permet d'inscrire en BDD la note du lieu
 *
 * @param PDO $pdo
 * @param integer $rate
 * @param integer $shopId
 * @param integer $userId
 * @return void
 */
function insertRating(PDO $pdo, int $rate, int $shopId, int $userId){
    //preparer la requête
    $query = $pdo->prepare('
    INSERT INTO ratings 
    (note, shopId, userId) 
    VALUES (?, ?, ?)');

    //executer la requête
    $query->execute([$rate, $shopId, $userId]);
}

/**
 * Permet de connaitre les notes d'un lieu
 *
 * @param PDO $pdo
 * @param [type] $shopId
 * @return void
 */
function getRatingById(PDO $pdo, $shopId){
    //prepare la requête
    $query = $pdo->prepare('
    SELECT AVG(note) as average, COUNT(note) as count  
    FROM ratings 
    WHERE shopId = ? ');

    //executer la requête
    $query->execute([$shopId]);

    return $query->fetch(PDO::FETCH_ASSOC);

}

/**
 * Permet de connaitre la date et le pseudo du dernier contributeur
 *
 * @param PDO $pdo
 * @param [type] $shopId
 * @return void
 */
function getLastContributeur(PDO $pdo, $shopId)
{
    //prepare la requête
    $query = $pdo->prepare('
    SELECT userId, commentDate, pseudo  
    FROM ratings 
    INNER JOIN users ON ratings.userId = users.id
    WHERE shopId = ? 
    ORDER BY commentDate DESC LIMIT 1');

    //executer la requête
    $query->execute([$shopId]);

    $lastContributeur= $query->fetch(PDO::FETCH_ASSOC);
    return $lastContributeur;
}


/**
 * Permet de savoir si le user a déjà commenté ce lieu
 * recherche du couple userId et shopId 
 *
 * @param PDO $pdo
 * @param integer $userId
 * @param integer $shopId
 * @return void
 */
function userHasAlreadyRate(PDO $pdo, int $userId, int $shopId)
{   
    //prepare la requête
    $query = $pdo->prepare('
    SELECT shopId, userId  
    FROM ratings 
    WHERE shopId = :shopId AND userId = :userId');

    //executer la requête
    $query->bindParam(':shopId', $shopId, PDO::PARAM_INT);
    $query->bindParam(':userId', $userId, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC); 
}


/**
 * Permet de mettre à jour l'image du lieu
 *
 * @param PDO $pdo
 * @param integer $shopId
 * @param string $link
 * @return void
 */
function updatePoiImage(PDO $pdo, int $shopId, string $link)
{
    //prepare la requête
    $query = $pdo->prepare('
    UPDATE shops 
    SET image = ?   
    WHERE id = ? ');

    //execute la requête
    $query->execute([htmlspecialchars($link), intval($shopId)]);

}