<?php
session_start();
error_reporting(E_ALL);
error_reporting(-1);

//Constante qui contiendra le chemin vers index.php
define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']));


//on sépare les paramètres passés dans l'URL
if (isset($_GET['p'])) {
    $path = explode('?', $_GET['p']);

    if ($path[0] != "") {
        $controller = $path[0];

        //on construit le chemin à appeler pour charger le contrôleur
        if (file_exists('libraries/controllers/' . $controller . '.php')) {
            require(ROOT . 'libraries/controllers/' . $controller . '.php');

        } else {

            //sinon rediriger vers la page d'erreur
            require(ROOT . 'page404.php');
            die();
        }
    } else {

        //si $path=null on affiche l'accueil
        $template = 'accueil.phtml';
        require('views/layout.phtml');

    }
} else {

    //si $_GET['p'] n'existe pas on affiche la page d'accueil
    $template = 'accueil.phtml';
    require('views/layout.phtml');
    
}
