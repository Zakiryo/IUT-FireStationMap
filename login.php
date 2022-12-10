<?php

/**
 * Connexion d'un utilisateur et vérification du informations du formulaires.
 */
session_start();
require_once 'database.php';
if (!empty($_POST['loginMail']) && !empty($_POST['loginPassword'])) {
    $loginMail = htmlspecialchars($_POST['loginMail']);
    $loginPassword = htmlspecialchars($_POST['loginPassword']);
    $check = $db->prepare('SELECT * FROM users WHERE mail = ?');
    $check->execute(array($loginMail));
    $data = $check->fetch();
    $row = $check->rowCount();
    if ($row == 1) {
        $loginPassword = hash('sha256', $loginPassword);
        if ($data['PASSWORD'] === $loginPassword) {
            $_SESSION['id'] = $data['ID'];
            $_SESSION['username'] = $data['USERNAME'];
            $_SESSION['firstname'] = $data['FIRSTNAME'];
            $_SESSION['lastname'] = $data['LASTNAME'];
            $_SESSION['mail'] = $data['MAIL'];
            header('Location:map.php');
        } else {
            header('Location:index.php?login_error=password');
        }
    } else {
        header('Location:index.php?login_error=not_exist');
    }
} else {
    header('Location:index.php');
}
