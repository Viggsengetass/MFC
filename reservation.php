<?php
// Configuration pour afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session (déplacer cette ligne en haut)
session_start();

// Vérification de la connexion de l'utilisateur
$utilisateur_id = $_SESSION['user']['id'] ?? null; // Utilisez la même clé 'user' que dans d'autres parties de votre application

if (!$utilisateur_id) {
    die("Vous devez être connecté pour faire une réservation.");
}

// Traitement du formulaire de réservation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $evenement_id = $_POST['evenement_id'];
    $nombre_billets = $_POST['nombre_billets'];

    // JavaScript pour afficher la popup
    echo "<script>
        var evenementNom = 'Nom de l\\'événement'; // Remplacez par le nom de l'événement
        alert('Votre réservation pour \"' + evenementNom + '\" avec ' + $nombre_billets + ' place(s) est confirmée.');
        window.location.href = 'panier.php'; // Rediriger vers la page du panier
    </script>";
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
        <h1 class="text-xl font-bold mb-4">Réservation d'Événement</h1>

        <form action="reservation.php" method="post" class="mt-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="evenement_id">
                    Sélectionnez un Événement
                </label>
                <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="evenement_id" name="evenement_id" required>
                    <option value="" disabled selected>Choisissez un événement</option>
                    <!-- Vous pouvez ajouter des options ici -->
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
