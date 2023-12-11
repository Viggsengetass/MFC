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
        #content {
            display: none; /* Cacher la liste de combattants */
        }
    </style>
</head>
<body>

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
