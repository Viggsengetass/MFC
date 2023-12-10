<?php
// Assurez-vous que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Supprime toutes les données de session
session_unset();

// Détruit la session
session_destroy();

// Redirige vers la page de connexion
header('Location: login.php');
exit();
?>
