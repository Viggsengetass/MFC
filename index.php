<?php
// Inclure le fichier common.php qui contient la connexion à la base de données et d'autres configurations
include 'common.php';

// Exemple de requête pour récupérer les événements à venir avec les détails des combattants
$query = "SELECT evenements_admin.*, combattants_admin.nom AS combattant1_nom, combattants_admin.image AS image1
          FROM evenements_admin
          LEFT JOIN combattants_admin ON evenements_admin.combattant_id = combattants_admin.id
          WHERE evenements_admin.date >= CURDATE()
          ORDER BY evenements_admin.date
          LIMIT 6";
$result = mysqli_query($conn, $query);

// Vérifier si la requête a réussi
if ($result) {
    // Convertir les résultats en un tableau associatif
    $evenements = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Gérer les erreurs de requête
    echo "Erreur de requête : " . mysqli_error($conn);
}

// Fermer la connexion à la base de données
mysqli_close($conn);
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
<body class="dark-neumorphic" style="margin-top: 7%;">
<!-- Section des événements à venir -->
<section class="container mx-auto mt-8">
    <h2 class="text-3xl font-semibold">Événements à venir</h2>

    <?php if (empty($evenements)) : ?>
        <p>Aucun événement à venir pour le moment.</p>
    <?php else : ?>
        <!-- Liste des événements à venir -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
            <?php foreach ($evenements as $evenement) : ?>
                <div class="bg-white p-4 rounded-lg shadow">
                    <?php if (!empty($evenement['image1']) && !empty($evenement['combattant1_nom'])) : ?>
                        <img src="<?= $evenement['image1'] ?>" alt="<?= $evenement['combattant1_nom'] ?>" class="w-full h-40 object-cover rounded">
                    <?php endif; ?>
                    <h3 class="text-xl font-semibold mt-2"><?= $evenement['nom'] ?></h3>
                    <p class="text-gray-500">Date : <?= date('d-m-Y', strtotime($evenement['date'])) ?></p>
                    <p class="mt-2"><?= $evenement['description'] ?></p>
                    <a href="#" class="text-blue-600 hover:underline mt-2">Réserver des billets</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- Ajoutez d'autres sections et fonctionnalités ici selon vos besoins -->

</body>
</html>
