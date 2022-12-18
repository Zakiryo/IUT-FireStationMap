<?php

/**
 * Enregistrement d'un nouvel utilisateur dans la base de données.
 */
require_once 'database.php';
if (!empty($_POST['registerUsername']) && !empty($_POST['registerMail']) && !empty($_POST['registerPassword']) && !empty($_POST['registerLastName']) && !empty($_POST['registerFirstName']) && !empty($_POST['registerAddress']) && !empty($_POST['registerCity']) && !empty($_POST['registerCode'])) {
    $registerUsername = htmlspecialchars($_POST['registerUsername']);
    $registerMail = htmlspecialchars($_POST['registerMail']);
    $registerPassword = htmlspecialchars($_POST['registerPassword']);
    $registerLastName = htmlspecialchars($_POST['registerLastName']);
    $registerFirstName = htmlspecialchars($_POST['registerFirstName']);
    $registerAddress = htmlspecialchars($_POST['registerAddress']);
    $registerCity = htmlspecialchars($_POST['registerCity']);
    $registerCode = htmlspecialchars($_POST['registerCode']);
    $check = $db->prepare('SELECT MAIL, USERNAME FROM users WHERE mail = :mail OR username = :username');
    $check->execute(array(
        'mail' => $registerMail,
        'username' => $registerUsername
    ));
    $data = $check->fetch();
    $row = $check->rowCount();

    if ($row == 0) {
        $registerPassword = hash('sha256', $registerPassword);
        $insert = $db->prepare("INSERT INTO `users` (`ID`, `USERNAME`, `LASTNAME`, `FIRSTNAME`, `PASSWORD`, `MAIL`, `ISADMIN`) VALUES (NULL, :username, :lastname, :firstname, :password, :mail, '0')");
        $insert->execute(array(
            'username' => $registerUsername,
            'lastname' => $registerLastName,
            'firstname' => $registerFirstName,
            'password' => $registerPassword,
            'mail' => $registerMail
        ));
        $getID = $db->prepare('SELECT ID FROM users WHERE mail = ?');
        $getID->execute(array($registerMail));
        $id = $getID->fetch();
        $insertAddress = $db->prepare("INSERT INTO `addresses` (`ID`, `USERID`, `ADDRESS`, `CITY`, `POSTALCODE`, `ISMAIN`) VALUES (NULL, :userid, :address, :city, :code, '1')");
        $insertAddress->execute(array(
            'userid' => $id['ID'],
            'address' => $registerAddress,
            'city' => $registerCity,
            'code' => $registerCode
        ));
        header('Location:../index.php?success');
    } else {
        header('Location:../registerPage.php?register_error=already_exist');
    }
} else {
    header('Location:../registerPage.php?register_error=empty');
}
