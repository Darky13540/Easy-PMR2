<?php
session_start();

//On vérifie si la $_SESSION['user'] existe
if (!isset($_SESSION['user'])) {
    header("Location: connexion");
    exit();
}

//On détruit la $_SESSION['user']
$_SESSION['user'] = [];
unset($_SESSION['user']);
header("Location: index.php");
