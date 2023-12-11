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

// Nombre de combattants par page
$combattantsParPage = 6;

// Nombre total de pages
$nombrePages = ceil(count($combattants) / $combattantsParPage);

// Page actuelle, par défaut 1
$pageActuelle = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Indice de début pour la pagination
$indiceDebut = ($pageActuelle - 1) * $combattantsParPage;

// Combattants à afficher sur la page actuelle
$combattantsPageActuelle = array_slice($combattants, $indiceDebut, $combattantsParPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combattants</title>
    <link rel="stylesheet" href="/style/dark-neumorphic.css">
    <link rel="stylesheet" href="/style/carousel.css"> <!-- Ajout du lien vers le nouveau fichier CSS -->
    <style>
        .carte-combattant {
            width: 200px;
            margin: 8px;
        }

        #content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        /* Ajout du style pour cacher les combattants dans le carrousel */
        .carousel-item .content {
            display: none;
        }
    </style>
</head>
<body>
<div id="content" class="container mx-auto mt-8">
    <!-- Votre liste de combattants -->
    <h1 class="text-3xl font-bold w-full mb-4">Liste des Combattants</h1>
    <?php foreach ($combattantsPageActuelle as $combattant) : ?>
        <div class="carte-combattant p-4 rounded-md mb-4">
            <img src="<?= $combattant['image'] ?>" alt="<?= $combattant['nom'] . ' ' . $combattant['prenom'] ?>">
            <h2 class="text-xl font-bold"><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></h2>
            <p class="mt-2"><strong>Surnom:</strong> <?= $combattant['surnom'] ?></p>
            <p class="mt-2"><strong>Description:</strong> <?= $combattant['description'] ?></p>
            <p class="mt-2"><strong>Catégorie:</strong> <?= isset($categories[$combattant['categorie_id']]) ? $categories[$combattant['categorie_id']] : 'Inconnue' ?></p>
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

<!-- Ajouter le code du carrousel après la liste de combattants -->
<div class="carousel-container">
    <div class="carousel-wrapper">
        <?php foreach ($combattants as $combattant) : ?>
            <div class="carousel-item">
                <img src="<?= $combattant['image'] ?>" alt="<?= $combattant['nom'] . ' ' . $combattant['prenom'] ?>">
                <div class="content">
                    <h2><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></h2>
                    <span>Surnom: <?= $combattant['surnom'] ?></span>
                    <span>Description: <?= $combattant['description'] ?></span>
                    <span>Catégorie: <?= isset($categories[$combattant['categorie_id']]) ? $categories[$combattant['categorie_id']] : 'Inconnue' ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // JavaScript pour le carrousel
    const carouselWrapper = document.querySelector('.carousel-wrapper');
    let currentIndex = 0;

    setInterval(() => {
        currentIndex = (currentIndex + 1) % <?= count($combattants) ?>; // Nombre total de combattants
        const translateValue = -currentIndex * 130; // 130 est la largeur d'un élément plus la marge
        carouselWrapper.style.transform = `translateX(${translateValue}px)`;
    }, 3000); // Changement toutes les 3 secondes, ajustez selon vos besoins
</script>

</body>
</html>
