<?php
session_start();
require_once("database.php");
if (isset($_POST['confirmPassword'])) {
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
        if (isset($_POST['modifyFirstName'])) {
            $modify = $db->prepare("UPDATE `users` SET `FIRSTNAME` = :newfirstname WHERE `ID` = :id");
            $modify->execute(array(
                'newfirstname' => htmlspecialchars($_POST['modifyFirstName']),
                'id' => $_SESSION['id']
            ));
        }
        if (isset($_POST['modifyLastName'])) {
            $modify = $db->prepare("UPDATE `users` SET `LASTNAME` = :newlastname WHERE `ID` = :id");
            $modify->execute(array(
                'newlastname' => htmlspecialchars($_POST['modifyLastName']),
                'id' => $_SESSION['id']
            ));
        }
        if (isset($_POST['modifyMail'])) {
            $modify = $db->prepare("UPDATE `users` SET `MAIL` = :newmail WHERE `ID` = :id");
            $modify->execute(array(
                'newmail' => htmlspecialchars($_POST['modifyMail']),
                'id' => $_SESSION['id']
            ));
        }
    } else {
        header('Location:account.php?update_error=wrong_password');
    }
} else {
    header('Location:account.php?update_error=password_not_set');
}
