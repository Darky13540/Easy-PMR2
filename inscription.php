<?php
session_start();
if(isset($_SESSION['user'])){
     header("Location: profil.php");
     exit();
 }
//tester si les champs sont vides
//https://www.php.net/manual/fr/function.openssl-encrypt

require 'Views/inscription.phtml';

if(isset($_POST)){
if (isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['ville'])){
           // tester si les 2 mots de passe ont bien la même valeur
if ($_POST['password'] != $_POST['password2']) {
        header('Location: inscription.php');
        exit(); 
}

//tester l'email (format)
if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
        header('Location: inscription.php');
        exit();       
}

require 'functionPass.php';
require 'bdconnect.php';

//encrypter le mot de passe
//voir https://www.php.net/manual/fr/function.openssl-encrypt
$pwd_crypted = cryptPassword($_POST['password']);

//preparer la requete
$query = $pdo->prepare('INSERT INTO users (pseudo, password, mail, ville) VALUES (?, ?, ?, ?);');
  
//executer la requete
$query->execute([$_POST['pseudo'], $pwd_crypted, $_POST['mail'], $_POST['ville']]);

// redirection vers index.php
 $id = $pdo->lastInsertId();
 

        //on stocke dans sessions les info
        $_SESSION['user'] = [
            'id' => $id,
            'pseudo' => $_POST["pseudo"],
            'mail' => $_POST["mail"]
            ];
        //on redirige vers la page de profil
        header("Location: profil.php");
        exit();
        var_dump($pwd_crypted); 
        var_dump($_POST['pseudo']);
        var_dump($_SESSION['user']); 
}
};