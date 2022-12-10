<?php

/**
 * Déconnexion de l'utilisateur courant et desctruction de la session.
 */
session_start();
session_destroy();
header('Location:index.php?disconnected');
