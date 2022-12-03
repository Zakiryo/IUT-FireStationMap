<?php
require_once 'database.php';
if (isset($_POST['registerUsername']) && isset($_POST['registerMail']) && isset($_POST['registerPassword']) && isset($_POST['registerLastName']) && isset($_POST['registerFirstName'])) {
    $registerUsername = htmlspecialchars($_POST['registerUsername']);
    $registerMail = htmlspecialchars($_POST['registerMail']);
    $registerPassword = htmlspecialchars($_POST['registerPassword']);
    $registerLastName = htmlspecialchars($_POST['registerLastName']);
    $registerFirstName = htmlspecialchars($_POST['registerFirstName']);
    $check = $db->prepare('SELECT MAIL, PASSWORD FROM users WHERE mail = ?');
    $check->execute(array($registerMail));
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
        header('Location:loginForm.php?success');
    } else {
        header('Location:loginForm.php?register_error=already_exist');
    }
} else {
    header('Location:loginForm.php?register_error=empty');
}
