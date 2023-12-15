<?php
session_start();
require_once 'common.php';
require_once 'reservation-functions.php'; // Utiliser le fichier de fonctions de réservation

$evenement_id = $_GET['id'] ?? 0;
$utilisateur_id = $_SESSION['utilisateur_id'] ?? null; // S'assurer que l'utilisateur est connecté

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_billets = $_POST['nombre_billets'];
    $result = ajouterReservation($conn, $utilisateur_id, $evenement_id, $nombre_billets);
    if ($result === true) {
        header('Location: panier.php');
        exit();
    } else {
        echo "Erreur lors de la réservation : " . $result;
    }
}

// Récupération des informations de l'événement
$query = "SELECT nom, date, heure, lieu FROM evenements WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $evenement_id);
$stmt->execute();
$result = $stmt->get_result();
$evenement = $result->fetch_assoc();
$stmt->close();

if (!$evenement) {
    die("Événement non trouvé.");
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
        <h1 class="text-xl font-bold mb-4">Réservation pour : <?= htmlspecialchars($evenement['nom']) ?></h1>
        <p>Date: <?= htmlspecialchars($evenement['date']) ?></p>
        <p>Heure: <?= htmlspecialchars($evenement['heure']) ?></p>
        <p>Lieu: <?= htmlspecialchars($evenement['lieu']) ?></p>

        <form action="reservation.php?id=<?= $evenement_id ?>" method="post" class="mt-4">
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
