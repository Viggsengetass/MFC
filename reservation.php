<?php
// Configuration pour afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session (déplacer cette ligne en haut)
session_start();

// Inclusion des fichiers nécessaires
require_once 'common.php';
require_once 'reservation-functions.php';

// Récupération de l'identifiant de l'événement depuis la requête GET
$evenement_id = $_GET['event_id'] ?? 0;

// Récupération de l'identifiant de l'utilisateur depuis la session
$utilisateur_id = $_SESSION['user']['id'] ?? null; // Utilisez la même clé 'user' que dans d'autres parties de votre application

// Vérification de la connexion de l'utilisateur
if (!$utilisateur_id) {
    die("Vous devez être connecté pour faire une réservation.");
}

// Récupération des informations de l'événement
$evenement = getEvenementDetails($conn, $evenement_id);

// Vérification si l'événement existe
if (!$evenement) {
    $erreur_message = "Erreur! Événement non trouvé."; // Message d'erreur personnalisé
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réservation d'Événement</title>
    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
</head>
<body class="bg-gray-100">
<div class="container mx-auto mt-10">
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <?php if (isset($erreur_message)) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold"><?= $erreur_message ?></strong>
            </div>
        <?php else : ?>
            <h1 class="text-xl font-bold mb-4">Réservation pour : <?= htmlspecialchars($evenement['nom']) ?></h1>
            <p>Date: <?= htmlspecialchars($evenement['date']) ?></p>
            <p>Heure: <?= htmlspecialchars($evenement['heure']) ?></p>
            <p>Lieu: <?= htmlspecialchars($evenement['lieu']) ?></p>

            <form action="reservation-process.php" method="post" class="mt-4">
                <input type="hidden" name="evenement_id" value="<?= $evenement_id ?>">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nombre_billets">
                        Nombre de Billets
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="nombre_billets" name="nombre_billets" type="number" min="1" required>
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Réserver
                </button>
            </form>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
