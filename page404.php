<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- base dossier -->
    <base href="http://localhost/PHP/projet/Easy-PMR2/">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Open+Sans&display=swap" rel="stylesheet">

    <!-- Normalize CSS-->
    <link rel="stylesheet" href="assets/css/normalize.css">

    <!-- CSS Perso -->
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Easy-PMR</title>

</head>
<?php
require('views/inc/header.phtml');
?>
<main>
    <h1>Erreur 404</h1>
    <div class="erreur404">
        <p>Oups.... Il semblerait que la page recherchée n'existe pas</p>
        <img src="assets/img/Oups.png" alt="erreur 404">
    </div>
</main>
<?php
require('views/inc/footer.phtml');
?>
</body>
</html>