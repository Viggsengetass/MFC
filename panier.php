<?php
session_start();
require_once 'common.php';
require_once 'admin-functions.php';
require_once 'reservation-functions.php';


$utilisateur_id = $_SESSION['utilisateur_id'];
$reservations = getReservationsUtilisateur($conn, $utilisateur_id);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre Panier</title>
    <!-- ... Intégration de Tailwind CSS ... -->
</head>
<body>
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Votre Panier</h1>
    <?php foreach ($reservations as $reservation): ?>
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            <p>Événement: <?= htmlspecialchars($reservation['nom']) ?></p>
            <p>Nombre de billets: <?= $reservation['nombre_billets'] ?></p>
            <!-- Ajoutez d'autres informations et actions si nécessaire -->
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
