<?php
require_once 'database.php';
if (!empty($_POST['registerUsername']) && !empty($_POST['registerMail']) && !empty($_POST['registerPassword']) && !empty($_POST['registerLastName']) && !empty($_POST['registerFirstName'])) {
    $registerUsername = htmlspecialchars($_POST['registerUsername']);
    $registerMail = htmlspecialchars($_POST['registerMail']);
    $registerPassword = htmlspecialchars($_POST['registerPassword']);
    $registerLastName = htmlspecialchars($_POST['registerLastName']);
    $registerFirstName = htmlspecialchars($_POST['registerFirstName']);
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
        header('Location:index.php?success');
    } else {
        header('Location:index.php?register_error=already_exist');
    }
} else {
    header('Location:index.php?register_error=empty');
}
