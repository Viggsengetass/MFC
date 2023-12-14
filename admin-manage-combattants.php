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
</head>
<body class="bg-gray-900 text-gray-100" style="padding-top: 5rem;">
<!-- Barre de navigation ici -->
<?php include_once 'common.php';?>

<div id="content" class="p-4">
    <h1 class="text-3xl font-bold mb-6">Gérer les Combattants</h1>
    <button id="addCombatantBtn" class="mb-4 px-4 py-2 bg-blue-600 rounded-lg hover:bg-blue-700 transition duration-300 focus:outline-none focus:ring focus:ring-blue-300">Ajouter un combattant</button>

        <!-- Formulaire pour ajouter un combattant -->
        <form action="admin-manage-combattants.php" method="post" enctype="multipart/form-data" class="bg-gray-800 p-6 rounded-lg shadow-xl">
            <input type="text" name="nom" placeholder="Nom" class="w-full px-3 py-2 mb-4 text-gray-700 bg-white border rounded shadow" required>
            <input type="text" name="prenom" placeholder="Prénom" class="w-full px-3 py-2 mb-4 text-gray-700 bg-white border rounded shadow" required>
            <input type="text" name="surnom" placeholder="Surnom" class="w-full px-3 py-2 mb-4 text-gray-700 bg-white border rounded shadow">
            <textarea name="description" placeholder="Description" class="w-full px-3 py-2 mb-4 text-gray-700 bg-white border rounded shadow"></textarea>
            <select name="categorie_id" class="w-full px-3 py-2 mb-4 text-gray-700 bg-white border rounded shadow" required>
                <?php
                $categories = getAllCategories($conn);
                foreach ($categories as $categorie) {
                    echo "<option value=\"{$categorie['id']}\">{$categorie['nom']}</option>";
                }
                ?>
            </select>
            <input type="file" name="image" class="w-full px-3 py-2 mb-4 text-gray-700 bg-white border rounded shadow">
            <input type="submit" name="add_combattant" value="Ajouter Combattant" class="px-6 py-3 bg-green-500 text-white rounded-lg shadow-lg hover:bg-green-600 transition duration-300 cursor-pointer">
        </form>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($combattants as $combattant): ?>
            <div class="card bg-gray-800 rounded-xl overflow-hidden shadow-xl hover:shadow-2xl transition duration-300">
                <img src="<?= htmlspecialchars($combattant['image']) ?: 'path/to/default-image.png' ?>" alt="Image de combattant" class="w-full h-32 object-cover">
                <div class="card-content p-4">
                    <h2 class="text-xl font-semibold"><?= htmlspecialchars($combattant['nom']) ?> <?= htmlspecialchars($combattant['prenom']) ?></h2>
                    <p class="text-gray-400"><?= htmlspecialchars($combattant['surnom']) ?></p>
                    <p class="text-sm mt-2"><?= htmlspecialchars($combattant['description']) ?></p>
                    <div class="flex justify-between items-center mt-4">
                        <a href="edit-combattant.php?id=<?= $combattant['id'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-2 rounded-lg shadow focus:outline-none focus:ring focus:ring-blue-300">Éditer</a>
                        <a href="delete-combattant.php?id=<?= $combattant['id'] ?>" class="bg-red-500 hover:bg-red-700 text-white py-1 px-2 rounded-lg shadow focus:outline-none focus:ring focus:ring-red-300" onclick="return confirmDelete()">Supprimer</a>
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