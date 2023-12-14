<?php
// admin-manage-combattants.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

$combattants = getAllCombattants($conn);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Combattants - Tableau de Bord Administratif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background-color: #000; /* Fond noir */
        }
        .card {
            border-radius: 15px;
            background: #212121;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5),
            -5px -5px 10px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: transform 0.2s;
            margin-bottom: 20px;
            width: 200px;
            height: 350px;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 120px; /* Hauteur de l'image */
            object-fit: cover;
        }
        .card-content {
            padding: 10px;
            color: #fff;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            margin-top: 5px;
            border-radius: 5px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            text-align: center;
        }
        .btn-danger {
            background-color: #dc3545;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
            gap: 20px;
        }
    </style>
    <script>
        function confirmDelete() {
            return confirm("Êtes-vous sûr de vouloir supprimer ce combattant ?");
        }
    </script>
</head>
<body>
<div id="sidebar">
    <!-- Contenu de la barre latérale ici -->
</div>
<div id="content" class="p-4">
    <h1 class="text-3xl font-bold mb-6 text-white">Gérer les Combattants</h1>
    <!-- Bouton pour ajouter un nouveau combattant -->
    <a href="admin-create-combattant.php" class="mb-4 p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter un combattant</a>

    <!-- Affichage des combattants existants -->
    <div class="grid-container">
        <?php foreach ($combattants as $combattant): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($combattant['image']) ?: 'path/to/default-image.png' ?>" alt="Image de combattant">
                <div class="card-content">
                    <h2 class="text-lg font-semibold"><?= htmlspecialchars($combattant['nom']) ?></h2>
                    <p><?= htmlspecialchars($combattant['prenom']) ?> "<?= htmlspecialchars($combattant['surnom']) ?>"</p>
                    <p><?= htmlspecialchars($combattant['description']) ?></p>
                    <a href="edit-combattant.php?id=<?= $combattant['id'] ?>" class="btn">Éditer</a>
                    <a href="delete-combattant.php?id=<?= $combattant['id'] ?>" class="btn btn-danger" onclick="return confirmDelete()">Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>