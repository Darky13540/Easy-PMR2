<?php

if (isset($_SESSION['user'])) {
   header("Location: profil");
   exit();
};
require(ROOT . '/libraries/models/notificationsmodel.php');

//On teste si les champs sont vides
if (!empty($_POST)) {

   //Ils sont remplis
   if (
      isset($_POST['mail']) && isset($_POST['password'])
      && !empty($_POST['mail'] && !empty($_POST['password']))
   ) {
   
      require(ROOT .'/libraries/models/usermodel.php');

      //On appelle dans la BDD le user avec le mail saisi
      $user = getUserFromEmail($pdo, $_POST['mail']);

      //test si l'email n'existe pas -> retour sur la page de connexion
      if (!$user) {
         addFlash('error', 'Le mot de passe et/ou login est incorrect');
         header('Location: connexion');
         die();
      }

      //si le user existe, on vérifie le MDP
      if (!verifPassword($_POST['password'], $user['password'])) {
         addFlash('error', 'Le mot de passe et/ou login est incorrect');
         header('Location: connexion');
         die();
           }

      //User + MDP ok

      //mise en place de la variable SESSION avec le retour de la BDD
      $_SESSION['user'] = [
         'id' => intVal($user['id']),
         'pseudo' => htmlspecialchars($user['pseudo']),
         'mail' => htmlspecialchars($user['mail']),
         'ville' => htmlspecialchars($user['ville']),
         'role' => intVal($user['role'])
      ];

      //Variable pour la fonction
      $userId = $_SESSION['user']['id'];

      //mise à jour de la date de login
      updateLoginDate($pdo, $userId);

      //on redirige vers la page de profil
      addFlash('success', 'Bienvenue sur votre page de profil');
      header('Location: profil');
      exit();
   }
}

$template = 'connexion.phtml';

require 'views/layout.phtml';
