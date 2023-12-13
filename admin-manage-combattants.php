<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

$combattants = getAllCombattants($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_combattant'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $surnom = $_POST['surnom'];
    $description = $_POST['description'];
    $categorie_id = $_POST['categorie_id'];

    $image = null;
    $targetDirectory = "/var/www/vhosts/nice-meitner.164-90-190-187.plesk.page/httpdocs/image-combattants/";

    // Vérifier si le dossier de destination existe, sinon le créer
    if (!file_exists($targetDirectory)) {
        if (!mkdir($targetDirectory, 0755, true)) {
            die('Échec de la création des répertoires...');
        }
    }

    if (!empty($_FILES['image']['name'])) {
        $targetFile = $targetDirectory . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = "image-combattants/" . basename($_FILES['image']['name']);
        } else {
            echo "<p>Erreur lors du téléchargement de l'image.</p>";
        }
    }

    if ($image && createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id)) {
        $combattants = getAllCombattants($conn);
    } else {
        echo "<p>Erreur lors de la création du combattant.</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Combattants - Tableau de Bord Administratif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Ajout du CSS personnalisé pour les cartes avec effet de neumorphisme */
        .card {
            width: 100%; /* Utilisation de la largeur complète dans le contexte d'un système de grille */
            border-radius: 30px;
            background: #212121;
            box-shadow: 15px 15px 30px rgba(25, 25, 25, 0.5),
            -15px -15px 30px rgba(60, 60, 60, 0.5);
            overflow: hidden; /* Pour que le border-radius s'applique aux images à l'intérieur */
        }
        .card img {
            transition: transform 0.3s ease-in-out;
        }
        .card:hover img {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100">
<div id="sidebar">
    <!-- Include the sidebar here -->
</div>
<div id="content" class="p-4 mt-10">
    <h1 class="text-3xl font-bold mb-6">Gérer les Combattants</h1>

    <button id="addCombatantBtn" class="mb-4 p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter un combattant</button>

    <div id="addCombatantForm" style="display:none;" class="mb-8 p-6 bg-gray-700 rounded">
        <!-- Form content -->
    </div>

    <!-- Liste des combattants -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($combattants as $combattant): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($combattant['image']) ?: 'path/to/default-image.png' ?>" alt="Image de combattant">
                <div class="p-4">
                    <h2 class="text-xl font-semibold"><?= htmlspecialchars($combattant['nom']) ?></h2>
                    <p class="text-gray-300"><?= htmlspecialchars($combattant['description']) ?></p>
                    <div class="flex justify-between items-center">
                        <a href="edit-combattant.php?id=<?= $combattant['id'] ?>" class="text-blue-300 hover:text-blue-400 hover:underline">Éditer</a>
                        <a href="delete-combattant.php?id=<?= $combattant['id'] ?>" class="text-red-300 hover:text-red-400 hover:underline">Supprimer</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.getElementById('addCombatantBtn').addEventListener('click', function() {
        var form = document.getElementById('addCombatantForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>
</body>
</html>
