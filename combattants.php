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
    <link rel="stylesheet" href="/style/carousel.css">
</head>
<body>

<div class="container">
    <?php foreach ($combattants as $combattant) : ?>
        <div class="card">
            <div class="card-content">
                <h2><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></h2>
                <span>Surnom: <?= $combattant['surnom'] ?></span>
                <span>Description: <?= $combattant['description'] ?></span>
                <span>Catégorie: <?= isset($categories[$combattant['categorie_id']]) ? $categories[$combattant['categorie_id']] : 'Inconnue' ?></span>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.querySelector('.container');
        const scrollRightButton = document.createElement('div');
        scrollRightButton.classList.add('scroll-button', 'scroll-right');
        scrollRightButton.innerHTML = '&rarr;'; // flèche vers la droite

        scrollRightButton.addEventListener('click', function() {
            container.scrollBy({ left: 300, behavior: 'smooth' }); // Ajustez la valeur selon vos besoins
        });

        document.body.appendChild(scrollRightButton);
    });
</script>

</body>
</html>
