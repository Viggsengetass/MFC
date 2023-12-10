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
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 16px; /* Espace entre les cartes */
        }

        .carte-evenement {
            width: calc(50% - 16px); /* Largeur de 50% avec espacement entre les cartes */
            margin-bottom: 16px;
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .carte-evenement img {
            width: 100%;
            max-height: 200px; /* Hauteur maximale de l'image */
            object-fit: cover; /* Ajustement de l'image pour couvrir la zone */
            border-radius: 4px;
            margin-bottom: 8px;
        }

        .carte-evenement h2 {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }

        .carte-evenement p {
            margin-bottom: 8px;
        }

        .carte-evenement .details {
            font-size: 0.9rem;
            color: #555;
        }

        .vs {
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            margin: 8px 0;
        }
    </style>
</head>
<body>
<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold w-full mb-4">Liste des Événements</h1>

    <?php
    $count = 0;
    foreach ($evenements as $evenement) : ?>
        <div class="carte-evenement">
            <img src="<?= $evenement['image1'] ?>" alt="<?= isset($evenement['combattant1_nom']) ? $evenement['combattant1_nom'] : 'Nom du combattant 1' ?>">
            <p class="vs">VS</p>
            <img src="<?= $evenement['image2'] ?>" alt="<?= isset($evenement['combattant2_nom']) ? $evenement['combattant2_nom'] : 'Nom du combattant 2' ?>">
            <h2><?= $evenement['nom'] ?></h2>
            <div class="details">
                <p><strong>Date:</strong> <?= date('d-m-Y', strtotime($evenement['date'])) ?></p>
                <p><strong>Heure:</strong> <?= date('H:i', strtotime($evenement['heure'])) ?></p>
                <p><strong>Lieu:</strong> <?= $evenement['lieu'] ?></p>
                <p><strong>Catégorie:</strong> <?= isset($categories[$evenement['categorie_id']]) ? $categories[$evenement['categorie_id']] : 'Inconnue' ?></p>
            </div>
        </div>
        <?php
        $count++;
        if ($count % 2 == 0) {
            echo '</div><div class="container mx-auto mt-8">';
        }
        ?>
    <?php endforeach; ?>
</div>
</body>
</html>
