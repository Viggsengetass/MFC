<?php
// combattants.php

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
    <link rel="stylesheet" href="/style/dark-neumorphic.css">
    <style>
        .carte-combattant {
            width: 200px; /* Réduire la largeur des cartes */
            margin: 8px; /* Ajouter de l'espace entre les cartes */
        }

        /* Créer une grille pour afficher 3 cartes par ligne */
        #content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }
    </style>
</head>
<body>
<div id="content" class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold w-full mb-4">Liste des Combattants</h1>

    <?php $count = 0; ?>
    <?php foreach ($combattants as $combattant) : ?>
    <div class="carte-combattant p-4 rounded-md mb-4">
        <img src="<?= $combattant['image'] ?>" alt="<?= $combattant['nom'] . ' ' . $combattant['prenom'] ?>">
        <h2 class="text-xl font-bold"><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></h2>
        <p class="mt-2"><strong>Surnom:</strong> <?= $combattant['surnom'] ?></p>
        <p class="mt-2"><strong>Description:</strong> <?= $combattant['description'] ?></p>
        <p class="mt-2"><strong>Catégorie:</strong> <?= isset($categories[$combattant['categorie_id']]) ? $categories[$combattant['categorie_id']] : 'Inconnue' ?></p>
    </div>
    <?php $count++; ?>
    <?php if ($count % 6 === 0) : ?> <!-- Début d'un nouveau groupe de 6 cartes -->
</div>
<div class="container mx-auto mt-8">
    <?php endif; ?>
    <?php endforeach; ?>
</div>
</body>
</html>
