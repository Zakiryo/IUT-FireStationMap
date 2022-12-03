<?php
session_start();
require_once 'database.php';
if (isset($_POST['loginMail']) && isset($_POST['loginPassword'])) {
    $loginMail = htmlspecialchars($_POST['loginMail']);
    $loginPassword = htmlspecialchars($_POST['loginPassword']);
    $check = $db->prepare('SELECT MAIL, PASSWORD FROM users WHERE mail = ?');
    $check->execute(array($loginMail));
    $data = $check->fetch();
    $row = $check->rowCount();
    if ($row == 1) {
        $loginPassword = hash('sha256', $loginPassword);
        if ($data['PASSWORD'] === $loginPassword) {
            $_SESSION['username'] = $data['USERNAME'];
            header('Location:index.php');
        } else {
            header('Location:loginForm.php?login_error=password');
        }
    } else {
        header('Location: loginForm.php?login_error=not_exist');
    }
} else {
    header('Location:loginForm.php');
}
