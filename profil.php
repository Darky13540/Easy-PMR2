<?php
session_start();
require ('notifications.php');
if(!isset($_SESSION['user'])){
    addFlash('error','Connectez vous pour accéder à la page');
    header("Location: connexion.php");
    exit();
}
require 'Views/profil.phtml';

