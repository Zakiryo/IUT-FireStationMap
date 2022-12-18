<?php
session_start();
require_once 'database.php';
try {
    $check = $db->prepare("INSERT INTO `favorites` (`ID`, `USERID`, `SECTOR`) VALUES (NULL, :userid, :sector)");
    $check->execute(array(
        'userid' => $_SESSION['id'],
        'sector' => $_POST['sector']
    ));
} catch (Exception $e) {
    echo $e->getMessage();
}
