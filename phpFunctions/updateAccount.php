<?php

/**
 * Mise à jour des informations du compte de la session actuelle côté serveur.
 */
session_start();
require_once("database.php");
if (!empty($_POST['confirmPassword'])) {
    $modifyPassword = htmlspecialchars($_POST['confirmPassword']);
    $modifyPassword = hash('sha256', $modifyPassword);
    $check = $db->prepare('SELECT * FROM users WHERE password = :password AND id = :id');
    $check->execute(array(
        'password' => $modifyPassword,
        'id' => $_SESSION['id']
    ));
    $data = $check->fetch();
    $row = $check->rowCount();
    if ($row == 1) {
        if (!empty($_POST['modifyFirstName']) || !empty($_POST['modifyLastName']) || !empty($_POST['modifyMail'])) {
            if (!empty($_POST['modifyMail'])) {
                $checkMail = $db->prepare('SELECT MAIL FROM users WHERE mail = ?');
                $checkMail->execute(array(htmlspecialchars($_POST['modifyMail'])));
                $dataMail = $checkMail->fetch();
                $rowMail = $checkMail->rowCount();
                if ($rowMail == 0) {
                    $modify = $db->prepare("UPDATE `users` SET `MAIL` = :newmail WHERE `ID` = :id");
                    $modify->execute(array(
                        'newmail' => htmlspecialchars($_POST['modifyMail']),
                        'id' => $_SESSION['id']
                    ));
                } else {
                    header('Location:../account.php?update_error=already_exist');
                    die();
                }
            }
            if (!empty($_POST['modifyFirstName'])) {
                $modify = $db->prepare("UPDATE `users` SET `FIRSTNAME` = :newfirstname WHERE `ID` = :id");
                $modify->execute(array(
                    'newfirstname' => htmlspecialchars($_POST['modifyFirstName']),
                    'id' => $_SESSION['id']
                ));
            }
            if (!empty($_POST['modifyLastName'])) {
                $modify = $db->prepare("UPDATE `users` SET `LASTNAME` = :newlastname WHERE `ID` = :id");
                $modify->execute(array(
                    'newlastname' => htmlspecialchars($_POST['modifyLastName']),
                    'id' => $_SESSION['id']
                ));
            }

            session_destroy();
            header('Location:../index.php?update_success');
            die();
        } else {
            header('Location:../account.php?update_error=all_empty');
            die();
        }
    } else {
        header('Location:../account.php?update_error=wrong_password');
        die();
    }
} else {
    header('Location:../account.php?update_error=password_not_set');
    die();
}
