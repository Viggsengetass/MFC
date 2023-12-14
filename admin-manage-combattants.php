<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

$combattants = getAllCombattants($conn);
$categories = getAllCategories($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_combattant'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $surnom = $_POST['surnom'];
    $description = $_POST['description'];
    $categorie_id = $_POST['categorie_id'];

    $image = null;
    $targetDirectory = "/var/www/vhosts/nice-meitner.164-90-190-187.plesk.page/httpdocs/image-combattants/";

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0755, true);
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
        header("Location: admin-manage-combattants.php");
        exit;
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
        /* Vos styles CSS ici */
    </style>
    <script>
        // Votre JavaScript ici
    </script>
</head>
<body>
<!-- Votre contenu HTML ici -->
</body>
</html>

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
    <button id="addCombatantBtn" class="mb-4 p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter un combattant</button>

    <!-- Formulaire d'ajout de combattant -->
    <div id="addCombatantForm" style="display: none;">
        <form action="" method="post" enctype="multipart/form-data">
            Nom: <input type="text" name="nom" required><br>
            Prénom: <input type="text" name="prenom" required><br>
            Surnom: <input type="text" name="surnom" required><br>
            Description: <textarea name="description" required></textarea><br>
            Catégorie: <select name="categorie_id" required>
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?= $categorie['id']; ?>"><?= $categorie['nom']; ?></option>
                <?php endforeach; ?>
            </select><br>
            Image: <input type="file" name="image" required><br>
            <input type="submit" name="add_combattant" value="Ajouter">
        </form>
    </div>

    <!-- Affichage des combattants existants -->
    <div class="grid-container">
        <?php foreach ($combattants as $combattant): ?>
            <div class="card">
                <img src="<?= htmlspecialchars($combattant['image']) ?: 'path/to/default-image.png' ?>" alt="<?= htmlspecialchars($combattant['nom']) ?>">
                <div class="card-content">
                    <h2 class="text-lg font-semibold"><?= htmlspecialchars($combattant['nom']) ?></h2>
                    <p><?= htmlspecialchars($combattant['description']) ?></p>
                    <!-- Boutons d'action -->
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