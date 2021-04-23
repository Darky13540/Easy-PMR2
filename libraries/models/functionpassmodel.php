<?php

const SECRETKEY = 'mysecretkey1234';

//déclaration des functions

/**
 * va retourner le mot de passe encrypté, passé en argument
 *
 * @param [type] $pass
 * /* @return string */

function cryptPassword($pass)
{
    /* hashage MDP le mot de passe */
    return openssl_encrypt($pass, "AES-128-ECB", SECRETKEY);
}

/**
 * va comparer un mot passe en clair et un mot de passe crypté
 *  renvoie true si ils sont égaux, false si c'est pas le cas
 *
 * @param [type] $pass
 * @param [type] $pass_hash
 * /* @return bool */

function verifPassword($pass, $pass_hash)
{
    //vérifier le mot de passe
    //https://www.php.net/manual/fr/function.openssl-decrypt


    if ($pass === openssl_decrypt($pass_hash, "AES-128-ECB", SECRETKEY)) {
        return true;
    }

    return false;
}
