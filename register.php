<?php
if (isset($_POST['registerUsername']) && isset($_POST['registerMail']) && isset($_POST['registerPassword']) && isset($_POST['registerLastName']) && isset($_POST['registerFirstName'])) {
    $username = $_POST['registerUsername'];
    $password = $_POST['registerPassword'];
    $firstname = $_POST['registerFirstName'];
    $lastname = $_POST['registerLastName'];
    $mail = $_POST['registerMail'];
    $user = 'root';
    $pass = 'root';
    $db = new PDO('mysql:host=localhost;dbname=firestationsmapdatabase', $user, $pass);
    $query = "INSERT INTO `users` (`ID`, `USERNAME`, `LASTNAME`, `FIRSTNAME`, `MAIL`, `PASSWORD`) VALUES (NULL, ':username', ':lastname', ':firstname', ':mail', ':password')";
    $result = $db->prepare($query);
    $result->execute(array(
        "username" => $username,
        "password" => password_hash($password, PASSWORD_DEFAULT),
        "firstname" => $firstname,
        "lastname" => $lastname,
        "mail" => $mail,
    ));
    echo "oe";
}
