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
        /* Styles CSS personnalisés */
        .event-card {
            background-color: white;
            padding: 1rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .event-image {
            width: 100%;
            height: 40rem; /* Ajustez la hauteur selon vos besoins */
            object-fit: cover;
            border-radius: 0.25rem;
            background-color: #ccc; /* Couleur de remplacement */
        }

        .event-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-top: 0.5rem;
        }

        .event-date {
            color: gray;
            margin-top: 0.5rem;
        }

        .event-description {
            margin-top: 1rem;
        }

        .event-link {
            color: #3182ce;
            text-decoration: underline;
            margin-top: 0.5rem;
            display: inline-block;
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
            <div class="event-card">
                <img src="<?= $evenement['image1'] ?>" alt="<?= isset($evenement['combattant1_nom']) ? $evenement['combattant1_nom'] : 'Nom du combattant inconnu' ?>" class="event-image">
                <h3 class="event-title"><?= $evenement['nom'] ?></h3>
                <p class="event-date">Date : <?= date('d-m-Y', strtotime($evenement['date'])) ?></p>
                <p class="event-description"><?= $evenement['description'] ?></p>
                <a href="#" class="event-link">Réserver des billets</a>
            </div>
        <?php endforeach; ?>

    </div>
</section>

<!-- Ajoutez d'autres sections et fonctionnalités ici selon vos besoins -->
<?php include_once 'footer.php'; ?>

</body>
</html>
