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

// Nombre d'événements par page
$evenementsParPage = 6;

// Nombre total de pages
$nombrePages = ceil(count($evenements) / $evenementsParPage);

// Page actuelle, par défaut 1
$pageActuelle = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Indice de début pour la pagination
$indiceDebut = ($pageActuelle - 1) * $evenementsParPage;

// Événements à afficher sur la page actuelle
$evenementsPageActuelle = array_slice($evenements, $indiceDebut, $evenementsParPage);
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

    <?php foreach ($evenementsPageActuelle as $evenement) : ?>
        <div class="carte-evenement p-4 rounded-md mb-4">
            <img src="<?= $evenement['image'] ?>" alt="<?= $evenement['nom'] ?>">
            <h2 class="text-xl font-bold"><?= $evenement['nom'] ?></h2>
            <p class="mt-2"><strong>Date:</strong> <?= $evenement['date'] ?></p>
            <p class="mt-2"><strong>Lieu:</strong> <?= $evenement['lieu'] ?></p>
            <p class="mt-2"><strong>Description:</strong> <?= $evenement['description'] ?></p>
        </div>
    <?php endforeach; ?>

    <!-- Afficher la pagination si nécessaire -->
    <?php if ($nombrePages > 1) : ?>
        <div class="flex justify-center mt-4">
            <?php for ($i = 1; $i <= $nombrePages; $i++) : ?>
                <a href="?page=<?= $i ?>" class="mx-2 p-2 bg-gray-800 text-white rounded-full"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
