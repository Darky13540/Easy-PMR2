<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();
/* Connexion à une base MySQL avec l'invocation de pilote */

$user = '229228';
$password = 'Azertyuiop1#';




try {
    $pdo = new PDO('mysql:host=mysql-darky13540.alwaysdata.net;dbname=darky13540_easy-pmr', $user, $password);
    
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}

$reponse = $pdo->query('SELECT * FROM shop');
$pdo = null;
$poi = $reponse->fetchAll();

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Easy-PMR</title>
</head>

<body>
    <header class="header">
        <img src="img/logo.png" alt="logo">
        <nav>
            <ul>
                <li><a href="index.php" title="Accueil">Accueil</a></li>
                <li id="current"><a href="easymap.php" title="carte des lieux">Map</a></li>
                <li><a href="menus.html">Menus</a></li>
                <li><a href="contacts.html">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main class="maineasymap">
        <div class="mapListContainer">
            <div id="mapid"></div>

            <div class="listpoi">

                <?php foreach ($poi as $item): ?>
                <div id="item<?= $item['idi'] ?>" class="item js-marker" data-type="<?= $item['type'] ?>" data-name="<?= $item['name'] ?>" data-lat="<?= $item['lat'] ?>" data-long="<?= $item['longitude'] ?>">
                <img src="https://fakeimg.pl/200/">
                <h2><?= $item['name'] ?></h2>
                <p><?= $item['type'] ?></p>
                </div>
                <?php endforeach;?>
            </div>  
    </main>

    <footer class="footer">
        <div class="container cols cols--2 gutter">

            <section class="social">
                <h2>Sur les réseaux sociaux</h2>
                <div>
                    <a href="#"><i class="icon-facebook"></i></a>
                    <a href="#"><i class="icon-instagram"></i></a>
                    <a href="#"><i class="icon-twitter"></i></a>
                    <a href="#"><i class="icon-linkedin"></i></a>
                </div>
            </section>
            <nav>
                <h2>A propos</h2>
                <ul class="unstyled">
                    <li><a href="#">Qui sommes-nous ?</a></li>
                    <li><a href="#">Nos services</a></li>
                    <li><a href="#">Contactez-nous</a></li>
                </ul>
            </nav>
            <nav>
                <h2>A propos</h2>
                <ul class="unstyled">
                    <li><a href="#">Plan du site</a></li>
                    <li><a href="#">Foire Aux Questions</a></li>

                    <li><a href="#">Informations légales</a></li>
                </ul>
            </nav>
        </div>
    </footer>
    <!-- Chargement librairie JS Leaflet pour affichage de la carte -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
    <script src="js/main.js"></script>
</body>

</html>