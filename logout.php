<?php
session_start();
session_unset(); // Supprime toutes les données de session
session_destroy(); // Détruit la session

// Redirige vers la page de connexion ou toute autre page souhaitée
header('Location: login.php');
exit();
?>
