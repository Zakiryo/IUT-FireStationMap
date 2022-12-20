<?php
session_start();
require_once('database.php');
if (!empty($_POST['newAddress']) && !empty($_POST['newCode']) && !empty($_POST['newCity'])) {
    $newAddress = htmlspecialchars($_POST['newAddress']);
    $newCode = htmlspecialchars($_POST['newCode']);
    $newCity = htmlspecialchars($_POST['newCity']);
    $insert = $db->prepare("INSERT INTO `addresses` (`ID`, `USERID`, `ADDRESS`, `CITY`, `POSTALCODE`, `ISMAIN`) VALUES (NULL, :userid, :address, :city, :code, '0')");
    $insert->execute(array(
        'userid' => $_SESSION['id'],
        'address' => $newAddress,
        'city' => $newCity,
        'code' => $newCode
    ));
    //array_push($_SESSION['addresses'], $newAddress . ", " . $newCity . " " . $newCode);
    $getID = $db->prepare("SELECT ID FROM addresses WHERE ADDRESS = :address AND USERID = :userid");
    $getID->execute(array(
        'userid' => $_SESSION['id'],
        'address' => $newAddress
    ));
    $dataID = $getID->fetch();
    array_push(
        $_SESSION['addresses'],
        array(
            'libelle' => $newAddress . ", " . $newCity . " " . $newCode,
            'id' => $dataID['ID']
        )
    );
    header('Location:../account.php');
} else {
    header('Location:../account.php?addError=empty');
}
