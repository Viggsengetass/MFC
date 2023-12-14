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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Ajoutez vos propres styles ici */
        .neumorphism {
            background-color: #333;
            border-radius: 10px;
            box-shadow: 5px 5px 10px #1c1c1c, -5px -5px 10px #4a4a4a;
        }
        .neumorphism-inset {
            box-shadow: inset 5px 5px 10px #1c1c1c, inset -5px -5px 10px #4a4a4a;
        }
    </style>
</head>
<body class="bg-gray-800 text-gray-200">
<!-- Sidebar -->
<?php include_once 'admin-sidebar.php'; ?>

<!-- Content -->
<div id="content" class="ml-15% mt-5rem p-4">
    <h1 class="text-3xl font-bold mb-6">Gérer les Combattants</h1>
    <button id="addCombatantBtn" class="mb-4 px-6 py-3 bg-blue-600 rounded-lg shadow-lg text-white font-semibold hover:bg-blue-700 transition duration-300">Ajouter un combattant</button>

    <div id="addCombatantForm" class="hidden">
        <!-- Formulaire pour ajouter un combattant -->
        <form action="admin-manage-combattants.php" method="post" enctype="multipart/form-data" class="bg-gray-700 p-6 rounded-lg shadow-xl neumorphism-inset">
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
                    $categories = getAllCategories($conn);
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
                <input type="submit" name="add_combattant" value="Ajouter Combattant" class="px-6 py-3 bg-green-500 text-white rounded-lg shadow-lg hover:bg-green-600 transition duration-300 cursor-pointer">
            </div>
        </form>
    </div>

    <!-- Cartes des combattants -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($combattants as $combattant): ?>
            <div class="neumorphism" style="width: 200px; height: 350px;">
                <img src="<?= htmlspecialchars($combattant['image']) ?: 'path/to/default-image.png' ?>" alt="Combattant" class="object-cover w-full h-40">
                <div class="p-4">
                    <h2 class="text-xl font-semibold"><?= htmlspecialchars($combattant['nom']) ?></h2>
                    <p><?= htmlspecialchars($combattant['description']) ?></p>
                    <!-- Les boutons d'action pour chaque combattant -->
                    <div class="mt-4">
                        <a href="edit-combattant.php?id=<?= $combattant['id'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 rounded-full text-xs">Éditer</a>
                        <a href="delete-combattant.php?id=<?= $combattant['id'] ?>" class="bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded-full text-xs" onclick="return confirmDelete()">Supprimer</a>
                    </div>
                </div>
            </div>
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