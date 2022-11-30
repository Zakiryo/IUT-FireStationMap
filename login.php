<?php
session_start();
if (isset($_POST['email']) && isset($_POST['password'])) {
    $username = $_POST['email'];
    $password = $_POST['password'];
    $user = 'root';
    $pass = 'root';
    $db = new PDO('mysql:host=localhost;dbname=firestationsmapdatabase', $user, $pass);
    $query = "SELECT * FROM `users` WHERE `USERNAME` = :username AND `PASSWORD` = :password";
    $result = $db->prepare($query);
    $result->execute(array(
        "username" => $username,
        "password" => $password
    ));
    $result->execute();

    if ($result->rowCount() > 0) {
        $data = $result->fetchAll();
        if (password_verify($password, $data[0]["PASSWORD"])) {
            $_SESSION['ID'] = $data[0]['ID'];
            header("index.html");
            die();
        } else {
            return;
        }
    }
}
