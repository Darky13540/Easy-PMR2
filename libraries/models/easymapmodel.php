<?php
    /**
     * Permet de récupérer tous les POI dans la BDD
     *
     * @param PDO $pdo
     * @return array
     */
    function getAllPoi(PDO $pdo){
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
    function getPoiByName(PDO $pdo,string $name){
        $reponse = $pdo->prepare("SELECT * FROM shop WHERE name= :name");
        $reponse->execute([':name' => $name]);
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
    function getPoiByType(PDO $pdo,string $type){
        $reponse = $pdo->prepare("SELECT * FROM shop WHERE type= :type");
        $reponse->execute([':type' => $type]);
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
    function getPoiByTypeName(PDO $pdo, string $type, string $name){
        $reponse = $pdo->prepare("SELECT * FROM shop WHERE type= :type AND name= :name");
        $reponse->execute([':type' => $type, ':name' => $name]);
        $poi = $reponse->fetchAll(PDO::FETCH_ASSOC);
        return $poi;
    }
