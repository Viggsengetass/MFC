<?php
// combattants.php

// Active l'affichage des erreurs pendant le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclut les fichiers nécessaires
include 'common.php';
include 'admin-functions.php';

// Définir le nombre de cartes par page
$cartesParPage = 4;

// Déterminer la page actuelle
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Récupérer les combattants pour la page actuelle
$combattants = getCombattantsParPage($conn, $page, $cartesParPage);

// Récupérer le nombre total de pages
$totalPages = getTotalPages($conn, $cartesParPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combattants</title>
    <link rel="stylesheet" href="/style/combattants.css">
</head>
<body>
<div id="content">
    <h1>Liste des Combattants</h1>

    <?php foreach ($combattants as $combattant) : ?>
        <div class="carte-combattant">
            <img src="<?= $combattant['image'] ?>" alt="<?= $combattant['nom'] . ' ' . $combattant['prenom'] ?>">
            <h2><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></h2>
            <p><strong>Surnom:</strong> <?= $combattant['surnom'] ?></p>
            <p><strong>Description:</strong> <?= $combattant['description'] ?></p>
            <p><strong>Catégorie:</strong> <?= getCategoryName($combattant['categorie_id'], $conn) ?></p>
        </div>
    <?php endforeach; ?>

    <!-- Ajouter la pagination en bas de la page -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>
</body>
</html>
