<?php
// evenements.php

// Active l'affichage des erreurs pendant le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclut les fichiers nécessaires
include 'common.php';
include 'admin-functions.php';

// Récupère tous les événements
$evenements = getAllEvenements($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements</title>
    <link rel="stylesheet" href="/style/dark-neumorphic.css">
    <style>
        .carte-evenement {
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
    <h1 class="text-3xl font-bold w-full mb-4">Liste des Événements</h1>

    <?php foreach ($evenements as $evenement) : ?>
        <div class="carte-evenement p-4 rounded-md mb-4">
            <h2 class="text-xl font-bold"><?= $evenement['nom'] ?></h2>
            <p class="mt-2"><strong>Date:</strong> <?= $evenement['date'] ?></p>
            <p class="mt-2"><strong>Lieu:</strong> <?= $evenement['lieu'] ?></p>
            <p class="mt-2"><strong>Description:</strong> <?= $evenement['description'] ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
