4<?php
session_start();
require_once 'database.php';
try {
    $check = $db->prepare("DELETE FROM favorites WHERE USERID = :userid AND SECTOR = :sector");
    $check->execute(array(
        'userid' => $_SESSION['id'],
        'sector' => $_POST['sector']
    ));
} catch (Exception $e) {
    echo $e->getMessage();
}
