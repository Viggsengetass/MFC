<?php
// Configuration pour afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session
session_start();

// Inclusion des fichiers nécessaires
require_once 'common.php';
require_once 'reservation-functions.php';
require_once 'admin-functions.php';

$evenements = getAllEvenements($conn);

$utilisateur_id = $_SESSION['user']['id'] ?? null;

if (!$utilisateur_id) {
    die("Vous devez être connecté pour faire une réservation.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $evenement_id = $_POST['evenement_id'];
    $nombre_billets = $_POST['nombre_billets'];
    $result = ajouterReservationAuPanier($conn, $utilisateur_id, $evenement_id, $nombre_billets);
    if ($result === true) {
        $_SESSION['message'] = "Réservation ajoutée avec succès au panier.";
        header('Location: panier.php');
        exit();
    } else {
        $erreur_message = "Erreur lors de la réservation : " . $result;
    }
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
        <?php endif; ?>

        <h1 class="text-xl font-bold mb-4">Réservation d'Événement</h1>

        <form action="reservation.php" method="post" class="mt-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="evenement_id">
                    Sélectionnez un Événement
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="evenement_id" name="evenement_id" required>
                    <option value="" disabled selected>Choisissez un événement</option>
                    <?php foreach ($evenements as $evenement) : ?>
                        <option value="<?= $evenement['id'] ?>"><?= htmlspecialchars($evenement['nom']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
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
    </div>
</div>
</body>
</html>
