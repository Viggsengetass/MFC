<?php
// combattants.php

// Active l'affichage des erreurs pendant le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclut les fichiers nécessaires
include 'common.php';
include 'admin-functions.php';

// Connexion à la base de données
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if (!$conn) {
    die("La connexion à la base de données a échoué.");
}

// Récupère tous les combattants
$combattants = getAllCombattants($conn);

// Nombre de combattants par page
$combattantsParPage = 4;

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
    <style>
        .carte-combattant {
            width: 200px; /* Réduire la largeur des cartes */
            margin: 8px; /* Ajouter de l'espace entre les cartes */
        }

        /* Créer une grille pour afficher 2 cartes par ligne */
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

    <?php foreach ($combattantsPageActuelle as $combattant) : ?>
        <div class="carte-combattant p-4 rounded-md mb-4">
            <img src="<?= $combattant['image'] ?>" alt="<?= $combattant['nom'] . ' ' . $combattant['prenom'] ?>">
            <h2 class="text-xl font-bold"><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></h2>
            <p class="mt-2"><strong>Surnom:</strong> <?= $combattant['surnom'] ?></p>
            <p class="mt-2"><strong>Description:</strong> <?= $combattant['description'] ?></p>
            <p class="mt-2"><strong>Catégorie:</strong> <?= getCategoryName($combattant['categorie_id'], $conn) ?></p>
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
