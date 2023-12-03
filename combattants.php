<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include 'config.php';
include 'admin-functions.php';

// Récupérer tous les combattants
$combattants = getAllCombattants($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combattants</title>
    <link rel="stylesheet" href="/style/combattants.css"> <!-- Assurez-vous d'avoir un fichier de styles CSS -->
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
            <p><strong>Catégorie ID:</strong> <?= $combattant['categorie_id'] ?></p>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
