<?php

/**
 * Connection à la base de données de l'application.
 */
try {
    $db = new PDO('mysql:host=localhost:8080;dbname=firestationsmapdatabase', 'root', 'root');
} catch (Exception $e) {
    die('Erreur de connexion à la base de données : ' . $e->getMessage());
}
