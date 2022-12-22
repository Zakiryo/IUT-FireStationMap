<?php

/**
 * Suppression d'une caserne favorite pour l'utilisateur connecté
 */
session_start();
require_once 'database.php';
$check = $db->prepare("DELETE FROM favorites WHERE USERID = :userid AND SECTOR = :sector");
$check->execute(array(
    'userid' => $_SESSION['id'],
    'sector' => $_POST['sector']
));
