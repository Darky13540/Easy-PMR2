<?php
const SECRETKEY = 'mysecretkey1234';
require ('bdconnect.php');
//déclaration des functions

/**
 * Permet de retourner le mot de passe encrypté, passé en argument
 *
 * @param string $pass
 * /* @return string */

function cryptPassword(string $pass)
{
    /* hashage MDP le mot de passe */
    return openssl_encrypt($pass, "AES-128-ECB", SECRETKEY);
}

/**
 * Permet de comparer un mot passe en clair et un mot de passe crypté
 *  renvoie true si ils sont égaux, false si c'est pas le cas
 *
 * @param string $pass
 * @param string $pass_hash
 * /* @return bool */

function verifPassword(string $pass, string $pass_hash)
{
    //vérifier le mot de passe
    //https://www.php.net/manual/fr/function.openssl-decrypt


    if ($pass === openssl_decrypt($pass_hash, "AES-128-ECB", SECRETKEY)) {
        return true;
    }

    return false;
}
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
    SELECT id, mail, password, role, ville, pseudo
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
    SELECT id, pseudo, password, role
    FROM users 
    WHERE pseudo LIKE ? LIMIT 1');

    //execute la requête
    $query->execute(['%' .$pseudo. '%']);

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Permet de rechercher l'user par son Id
 *
 * @param PDO $pdo
 * @param integer $id
 * @return false ou array
 */
function getUserFromId(PDO $pdo, int $id){
    //prepare la requête
    $query = $pdo->prepare('
    SELECT id, pseudo, role, password 
    FROM users 
    WHERE id = ? LIMIT 1');

    //executer la requête
    $query->execute([$id]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet de récupérer l'ensemble des users
 *
 * @param PDO $pdo
 * @return array
 */
function getAllUsers(PDO $pdo){
    //prepare la requête
    $query = $pdo->prepare('
    SELECT id, pseudo, role 
    FROM users');

    //executer la requête
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
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
function insertUser(PDO $pdo, string $pseudo, string $pwd_crypted, string $mail, string $ville)
{
    //preparer la requête
    $query = $pdo->prepare('
    INSERT INTO users 
    (pseudo, password, mail, ville) 
    VALUES (?, ?, ?, ?);');

    //executer la requête
    $query->execute([$pseudo, $pwd_crypted, $mail, $ville]);

    $id = $pdo->lastInsertId();

    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet de mettre à jour la date de dernière connexion
 *
 * @param PDO $pdo
 * @param integer $userId
 * @return void
 */
function updateLoginDate(PDO $pdo, int $userId)
{
    //preparer la requête
    $query = $pdo->prepare('
    UPDATE users 
    SET LastLogin = NOW() 
    WHERE Id = ?');

    //executer la requête
    $query->execute([$userId]);
}

/**
 * Permet de modifier le mail et/ou la ville de résidence
 *
 * @param PDO $pdo
 * @param string $mail
 * @param string $ville
 * @param integer $userId
 * @return void
 */
function updateUser(PDO $pdo, string $mail, string $ville, int $userId)
{
    //preparer la requête
    $query = $pdo->prepare('
    UPDATE users SET mail = ?, ville= ?
    WHERE Id = ?');

    //executer la requête
    $query->execute([$mail, $ville, $userId]);
}

/**
 * Permet de mettre à jour le mdp dans la bdd
 *
 * @param PDO $pdo
 * @param string $pwd_crypted
 * @param integer $userId
 * @return void
 */
function updatePwd(PDO $pdo, string $pwd_crypted, int $userId)
{
    //preparer la requête
    $query = $pdo->prepare('
    UPDATE users SET password = ?
    WHERE Id = ?');

    //executer la requête
    $query->execute([$pwd_crypted, $userId]);
}

/**
 * Permet de changer le role du user
 *
 * @param PDO $pdo
 * @param integer $id
 * @param integer $role
 * @return void
 */
function changeRole(PDO $pdo, int $id, int $role)
{

    //prepare la requête
    $query = $pdo->prepare('
    UPDATE users
    SET role = ? 
    WHERE id = ? LIMIT 1');

    //execute la requête
    $query->execute([$role, $id]);

    return $query->fetch(PDO::FETCH_ASSOC);
}

/**
 * Permet de supprimer un user de la BDD
 *
 * @param PDO $pdo
 * @param integer $id
 * @return void
 */
function deleteUser(PDO $pdo, int $id){
    //prepare la requête
    $query = $pdo->prepare('
    DELETE FROM users 
    WHERE id = ? LIMIT 1');
    //execute la requête
    $query->execute([$id]);

    $query->fetch(PDO::FETCH_ASSOC);
}