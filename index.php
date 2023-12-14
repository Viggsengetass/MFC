<?php
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
    <title>Accueil - M.F.C MMA Tournament</title>
    <link rel="stylesheet" href="/style/dark-neumorphic.css">
    <link rel="stylesheet" href="/style/index.css">
    <style>
        /* Style pour gérer l'affichage en cas d'erreur de l'image */
        .image-placeholder {
            width: 100%;
            height: 40rem; /* Ajustez la hauteur selon vos besoins */
            background-color: #ccc; /* Couleur de remplacement */
        }
    </style>
    <script src="/js/index.js"></script>
</head>
<body>

<!-- Section des événements à venir -->
<section class="container mx-auto mt-8">
    <h2 class="text-3xl font-semibold">Événements à venir</h2>
    <!-- Liste des événements à venir -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">

        <?php
        // Parcourir les événements et les afficher dans les cartes
        foreach ($evenements as $evenement) :
            ?>
            <div class="bg-white p-4 rounded-lg shadow">
                <img src="<?= $evenement['image1'] ?>" alt="<?= isset($evenement['combattant1_nom']) ? $evenement['combattant1_nom'] : 'Nom du combattant inconnu' ?>" class="w-full h-40 object-cover rounded image-placeholder">
                <h3 class="text-xl font-semibold mt-2"><?= $evenement['nom'] ?></h3>
                <p class="text-gray-500">Date : <?= date('d-m-Y', strtotime($evenement['date'])) ?></p>
                <p class="mt-2"><?= $evenement['description'] ?></p>
                <a href="#" class="text-blue-600 hover:underline mt-2">Réserver des billets</a>
            </div>
        <?php endforeach; ?>

    </div>
</section>

<!-- Ajoutez d'autres sections et fonctionnalités ici selon vos besoins -->
<?php include_once 'footer.php'; ?>

</body>
</html>
