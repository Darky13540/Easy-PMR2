<?php
session_start();
if(isset($_SESSION['user'])){
     header("Location: profil.php");
     exit();
 }
//tester si les champs sont vides
//https://www.php.net/manual/fr/function.openssl-encrypt

require 'notifications.php';

if(isset($_POST)){
        if (isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['ville'])){
                // tester si les 2 mots de passe ont bien la même valeur
                if ($_POST['password'] != $_POST['password2']) {
                        addFlash('error','Les mots de passe saisis ne correspondent pas');
                        header('Location: inscription.php');
                        die();  
                }
                
                //tester l'email (format)
                if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) {
                        addFlash('error','Le mail est invalide');
                        header('Location: inscription.php');
                        die();      
                }
                
                require 'functionPass.php';
                require 'bdconnect.php';
  
                //encrypter le mot de passe
                //voir https://www.php.net/manual/fr/function.openssl-encrypt
$pwd_crypted = cryptPassword($_POST['password']);

//preparer la requête
$query = $pdo->prepare('INSERT INTO users (pseudo, password, mail, ville) VALUES (?, ?, ?, ?);');

//executer la requête
$query->execute([$_POST['pseudo'], $pwd_crypted, $_POST['mail'], $_POST['ville']]);

$id = $pdo->lastInsertId();
 

 //on stocke dans $_SESSION les infos
 $_SESSION['user'] = [
            'id' => $id,
            'pseudo' => $_POST["pseudo"],
            'mail' => $_POST["mail"]
            ];
            //on redirige vers la page de profil
                addFlash('success','Inscription prise en compte');
                header("Location: profil.php");
                exit();
}
};
require 'Views/inscription.phtml';