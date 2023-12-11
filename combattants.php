<?php
// combattants.php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'common.php';
include 'admin-functions.php';

$combattants = getAllCombattants($conn);

$combattantsParPage = 6;
$nombrePages = ceil(count($combattants) / $combattantsParPage);
$pageActuelle = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$indiceDebut = ($pageActuelle - 1) * $combattantsParPage;
$combattantsPageActuelle = array_slice($combattants, $indiceDebut, $combattantsParPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combattants</title>
    <link rel="stylesheet" href="/style/dark-neumorphic.css">
    <link rel="stylesheet" href="/style/carousel.css">
    <style>
        #content {
            display: none;
        }

        .carousel-item .content {
            display: none;
        }
    </style>
</head>
<body>
<div id="content" class="container mx-auto mt-8">
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
    <?php if ($nombrePages > 1) : ?>
        <div class="flex justify-center mt-4">
            <?php for ($i = 1; $i <= $nombrePages; $i++) : ?>
                <a href="?page=<?= $i ?>" class="mx-2 p-2 bg-gray-800 text-white rounded-full"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>

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
    const carouselWrapper = document.querySelector('.carousel-wrapper');
    let currentIndex = 0;

    setInterval(() => {
        currentIndex = (currentIndex + 1) % <?= count($combattants) ?>;
        const translateValue = -currentIndex * 250;
        carouselWrapper.style.transform = `translateX(${translateValue}px)`;
    }, 3000);
</script>
</body>
</html>
