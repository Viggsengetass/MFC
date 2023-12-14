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
<body class="bg-black mt-20"> <!-- margin-top de 20% -->
<div id="sidebar">
    <!-- Contenu de la barre latérale (si présent) -->
</div>
<div id="content" class="p-4">
    <h1 class="text-3xl font-bold mb-6 text-white">Gérer les Combattants</h1>
    <button id="addCombatantBtn" class="mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-300">Ajouter un combattant</button>

    <div id="addCombatantForm" class="hidden"> <!-- Utilisation de la classe hidden de Tailwind -->
        <form action="admin-manage-combattants.php" method="post" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <div class="mb-4">
                <input type="text" name="nom" placeholder="Nom" class="w-full px-3 py-2 text-gray-700 bg-white border rounded shadow" required>
            </div>
            <div class="mb-4">
                <input type="text" name="prenom" placeholder="Prénom" class="w-full px-3 py-2 text-gray-700 bg-white border rounded shadow" required>
            </div>
            <div class="mb-4">
                <input type="text" name="surnom" placeholder="Surnom" class="w-full px-3 py-2 text-gray-700 bg-white border rounded shadow">
            </div>
            <div class="mb-4">
                <textarea name="description" placeholder="Description" class="w-full px-3 py-2 text-gray-700 bg-white border rounded shadow"></textarea>
            </div>
            <div class="mb-4">
                <select name="categorie_id" class="w-full px-3 py-2 text-gray-700 bg-white border rounded shadow" required>
                    <?php
                    // Chargez ici les catégories depuis la base de données
                    $categories = getAllCategories($conn); // Assurez-vous que cette fonction fonctionne correctement
                    foreach ($categories as $categorie) {
                        echo "<option value=\"{$categorie['id']}\">{$categorie['nom']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-4">
                <input type="file" name="image" class="w-full px-3 py-2 text-gray-700 bg-white border rounded shadow">
            </div>
            <div>
                <input type="submit" name="add_combattant" value="Ajouter Combattant" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700 transition duration-300 cursor-pointer">
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($combattants as $combattant): ?>
            <!-- Ici, votre code HTML pour chaque carte de combattant -->
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.getElementById('addCombatantBtn').addEventListener('click', function() {
        var form = document.getElementById('addCombatantForm');
        form.classList.toggle('hidden');
    });
</script>
</body>
</html>