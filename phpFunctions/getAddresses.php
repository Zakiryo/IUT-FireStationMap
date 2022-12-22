<?php

/**
 * Récupération de toutes les adresses de l'utilisateur connecté
 */
session_start();
require_once('database.php');
$check = $db->prepare('SELECT * FROM addresses WHERE USERID = ? AND ISMAIN = 0');
$check->execute(array($_SESSION['id']));
$data = $check->fetchAll();
echo json_encode($data);
