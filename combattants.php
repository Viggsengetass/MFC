<?php
// Active l'affichage des erreurs pendant le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclut les fichiers nécessaires
include 'common.php';
include 'admin-functions.php';

// Récupère tous les combattants
$combattants = getAllCombattants($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combattants</title>
    <!-- Pas besoin de re-déclarer le lien Tailwind ici car il est déjà inclus dans common.php -->
</head>
<body class="bg-gray-100">
<div id="content" class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-4">Liste des Combattants</h1>

    <?php foreach ($combattants as $combattant) : ?>
        <div class="carte-combattant bg-white p-4 rounded-md shadow-md mb-4">
            <img src="<?= $combattant['image'] ?>" alt="<?= $combattant['nom'] . ' ' . $combattant['prenom'] ?>" class="rounded-full mb-4">
            <h2 class="text-xl font-semibold mb-2"><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></h2>
            <p><strong>Surnom:</strong> <?= $combattant['surnom'] ?></p>
            <p class="mt-2"><strong>Description:</strong> <?= $combattant['description'] ?></p>
            <p class="mt-2"><strong>Catégorie:</strong> <?= isset($categories[$combattant['categorie_id']]) ? $categories[$combattant['categorie_id']] : 'Inconnue' ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
