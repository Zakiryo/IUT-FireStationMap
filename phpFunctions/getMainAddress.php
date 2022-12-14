<?php
session_start();
require_once('database.php');
$check = $db->prepare('SELECT * FROM addresses WHERE USERID = ? AND ISMAIN = 1');
$check->execute(array($_SESSION['id']));
$data = $check->fetch();
echo json_encode($data);
