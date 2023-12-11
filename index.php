<?php
// index.php

// Active l'affichage des erreurs pendant le développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Inclut les fichiers nécessaires
include 'common.php';
include 'admin-functions.php';

// Récupère tous les événements triés par date
$evenements = getAllEvenements($conn);
usort($evenements, function ($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - M.F.C MMA Tournament</title>
    <?php include 'common.php'; ?>
    <link rel="stylesheet" href="/style/index.css">
    <script src="/js/index.js"></script>
</head>

<body class="dark-theme">

<!-- Section des événements à venir -->
<section class="container mx-auto mt-8">
    <h2 class="text-3xl font-semibold">Événements à venir</h2>
    <!-- Liste des événements à venir -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        <?php foreach ($evenements as $evenement) : ?>
            <div class="bg-white dark:bg-gray-800 p-4 rounded-lg shadow">
                <img src="<?= $evenement['image1'] ?>" alt="<?= $evenement['combattant1_nom'] ?>" class="w-full h-40 object-cover rounded">
                <h3 class="text-xl font-semibold mt-2"><?= $evenement['nom'] ?></h3>
                <p class="text-gray-500">Date : <?= date('d-m-Y', strtotime($evenement['date'])) ?></p>
                <p class="mt-2"><?= $evenement['description'] ?></p>
                <a href="#" class="text-blue-600 hover:underline mt-2">Réserver des billets</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Ajoutez d'autres sections et fonctionnalités ici selon vos besoins -->

</body>

</html>
