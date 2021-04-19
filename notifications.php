<?php

/**
 * Permet d'ajouter une notification
 *
 * @param string $type
 * @param string $message
 */
function addFlash(string $type, string $message)
{
    if (empty($_SESSION['messages'])) {
        $_SESSION['messages'] = [
            'error' => [],
            'success' => [],
        ];
    }
    $_SESSION['messages'][$type][] = $message;
}

/**
 * Permet de récupérer la notification
 *
 * @param string $type
 * @return array
 */
function getFlashes(string $type): array
{
    if (empty($_SESSION['messages'])) {
        return [];
    }

    $messages = $_SESSION['messages'][$type];

    $_SESSION['messages'][$type] = [];

    return $messages;
}

/**
 * Permet de savoir si il existe des messages d'un certain type
 *
 * @param string $type
 * @return boolean
 */
function hasFlashes(string $type): bool
{
    if (empty($_SESSION['messages'])) {
        return false;
    }

    return !empty($_SESSION['messages'][$type]);
}
