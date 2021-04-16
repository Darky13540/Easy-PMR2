<?php
session_start();

 if(isset($_SESSION['user'])){
     header("Location: profil.php");
     exit();
};
require 'utils.php';

if(!empty($_POST)){
    if(isset($_POST['mail']) && isset($_POST['password'])
    && !empty($_POST['mail'] && !empty($_POST['password']))
    ){
     require 'functionPass.php';
     require 'bdconnect.php';
     

     
    /*Préparation pour vérification des informations de connexion*/

    //preparer la requête
     
     $query = $pdo->prepare('SELECT id, pseudo, password, mail FROM users WHERE mail = ? LIMIT 1');
     
     //executer la requête
     $query->execute([$_POST['mail']]);
     
     $user = $query->fetch(PDO::FETCH_ASSOC);
     
    //test si l'email n'existe pas -> retour sur la page de connexion
       if(!$user) {
        addFlash('error','Le mot de passe et/ou login est incorrect');
        header('Location: connexion.php');
        die();
        }

     /* si le user existe, on vérifie le MDP */

     
        if(!verifPassword($_POST['password'], $user['password'])) {
        addFlash('error','Le mot de passe et/ou login est incorrect');
        header('Location: connexion.php');
        die();
        /*echo("Le mot de passe et/ou le login est incorrect"); */
        /* exit(); */
        }
        
        /* User + MDP ok */
        
        //mise en place de la variable SESSION
        $_SESSION['user'] = [
        'id' => intVal($user['id']),
        'pseudo' => htmlspecialchars($user['pseudo']),
        'mail' => htmlspecialchars($user['mail'])
        ];

        /* mise à jour de la date de login */
        
        //preparer la requête
        $query = $pdo->prepare('
        UPDATE users SET LastLogin = NOW() 
        WHERE id = ?');
        
        //executer la requête
        $query->execute([$_SESSION['user']['id']]);
        
        //on redirige vers la page de profil
        addFlash('success','Bienvenue sur votre page de profil');
        header('Location: profil.php');
        exit();
    }
 }
 require 'Views/connexion.phtml';