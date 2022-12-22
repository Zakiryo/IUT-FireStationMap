<?php

/**
 * Suppression d'une adresse secondaire pour l'utilisateur connecté
 */
session_start();
require_once('database.php');
$delete = $db->prepare("DELETE FROM addresses WHERE ID = ?");
$delete->execute(array($_POST['addressID']));
unset($_SESSION['addresses'][$_POST['keyValue']]);
header('Location:../account.php');
