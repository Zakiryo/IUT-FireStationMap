<?php
/**
 * Récupération de tous les favoris de l'utilisateur connecté
 */
session_start();
require_once 'database.php';
$check = $db->prepare("SELECT * FROM favorites WHERE USERID = :userid AND SECTOR = :sector");
$check->execute(array(
    'userid' => $_SESSION['id'],
    'sector' => $_POST['sector']
));
$data = $check->fetch();
$row = $check->rowCount();
echo $row == 0;
