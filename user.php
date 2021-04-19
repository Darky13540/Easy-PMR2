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
    SELECT id, mail, password
    FROM users 
    WHERE mail = ? LIMIT 1');

    //execute la requête
    $query->execute([$email]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet de vérifier si le pseudo est déjà dans la BDD
 *
 * @param PDO $pdo
 * @param string $pseudo
 * @return false ou array
 */
function getUserFromPseudo(PDO $pdo, string $pseudo)
{
    //prepare la requête
    $query = $pdo->prepare('
    SELECT id, pseudo, password
    FROM users 
    WHERE pseudo = ? LIMIT 1');

    //execute la requête
    $query->execute([$pseudo]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet d'insérer un nouvel utilisateur dans la BDD
 *
 * @param PDO $pdo
 * @param string $pseudo
 * @param string $pwd_crypted
 * @param string $mail
 * @param string $ville
 * @return void
 */
function signIn(PDO $pdo, string $pseudo, string $pwd_crypted, string $mail, string $ville)/*  */
{
    //preparer la requête
    $query = $pdo->prepare('INSERT INTO users (pseudo, password, mail, ville) VALUES (?, ?, ?, ?);');

    //executer la requête
    $query->execute([$pseudo, $pwd_crypted, $mail, $ville]);

    $id = $pdo->lastInsertId();

    return $query->fetch(PDO::FETCH_ASSOC);
}
