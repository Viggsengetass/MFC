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
        body {
            background-color: #000; /* Fond noir */
        }
        .card {
            width: 200px;
            height: 370px;
            border-radius: 15px;
            background: #212121;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.5),
            -5px -5px 10px rgba(255, 255, 255, 0.1);
            overflow: hidden;
            transition: transform 0.2s;
            margin-bottom: 20px;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card img {
            width: 100%;
            height: 120px; /* Ajustement de la hauteur de l'image */
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
</head>
<body>
<div id="sidebar">
    <!-- Contenu de la barre latérale (si présent) -->
</div>
<div id="content" class="p-4">
    <h1 class="text-3xl font-bold mb-6 text-white">Gérer les Combattants</h1>
    <button id="addCombatantBtn" class="mb-4 p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter un combattant</button>

    <div class="grid-container">
        <?php foreach ($combattants as $combattant): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($combattant['image']) ?: 'path/to/default-image.png' ?>" alt="Image de combattant">
                <div class="card-content">
                    <h2 class="text-lg font-semibold"><?= htmlspecialchars($combattant['nom']) ?></h2>
                    <p><?= htmlspecialchars($combattant['prenom']) ?> "<?= htmlspecialchars($combattant['surnom']) ?>"</p>
                    <p><?= htmlspecialchars($combattant['description']) ?></p>
                    <a href="edit-combattant.php?id=<?= $combattant['id'] ?>" class="btn">Éditer</a>
                    <a href="delete-combattant.php?id=<?= $combattant['id'] ?>" class="btn btn-danger">Supprimer</a>
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