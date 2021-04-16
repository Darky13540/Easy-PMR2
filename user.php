<?php
/**
 * Permet de vérifier si l'email est déjà dans la BDD
 *
 * @param PDO $pdo
 * @param string $email
 * @return false ou array
 */
function getUserFromEmail(PDO $pdo, string $email) 
{
    //prepare la requête
    $query = $pdo->prepare('
    SELECT Id, Email, Password, Admin
    FROM users 
    WHERE Email = ? LIMIT 1');

    //execute la requête
    $query->execute([$email]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

///////////////////////a mettre dans traitement

//chercher un user qui possède l'email
    /* $user = getUserFromEmail($pdo, $_POST['mail']);

    //test si l'email n'existe pas dans la base de données
    if($user) 
    {
       addFlash('error','Vous êtes déjà inscrit');
       header('Location: login.php');
       exit(); 
    } */