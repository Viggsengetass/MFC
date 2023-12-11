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
    <script src="/js/carousel.js"></script>

</head>
<body>

<div class="container">
    <?php foreach ($combattants as $combattant) : ?>
        <div class="card">
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

</body>
</html>
