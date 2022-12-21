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
        $checkAddress = $db->prepare('SELECT * FROM addresses WHERE USERID = ? AND ISMAIN = 0');
        $checkAddress->execute(array($data['ID']));
        $dataAddress = $checkAddress->fetchAll();

        $checkMainAddress = $db->prepare('SELECT * FROM addresses WHERE USERID = ? AND ISMAIN = 1');
        $checkMainAddress->execute(array($data['ID']));
        $dataMainAddress = $checkMainAddress->fetch();

        if (password_verify($loginPassword, $data['PASSWORD'])) {
            $_SESSION['id'] = $data['ID'];
            $_SESSION['username'] = $data['USERNAME'];
            $_SESSION['firstname'] = $data['FIRSTNAME'];
            $_SESSION['lastname'] = $data['LASTNAME'];
            $_SESSION['mail'] = $data['MAIL'];
            $_SESSION['mainaddress'] = $dataMainAddress['ADDRESS'] . ", " . $dataMainAddress['CITY'] . " " . $dataMainAddress['POSTALCODE'];
            $_SESSION['addresses'] = array();
            foreach ($dataAddress as $address) {
                array_push(
                    $_SESSION['addresses'],
                    array(
                        'libelle' => $address['ADDRESS'] . ", " . $address['CITY'] . " " . $address['POSTALCODE'],
                        'id' => $address['ID']
                    )
                );
            }
            header('Location:../map.php');
        } else {
            header('Location:../index.php?login_error=password');
        }
    } else {
        header('Location:../index.php?login_error=not_exist');
    }
} else {
    header('Location:../index.php');
}
