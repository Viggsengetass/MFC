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

    $image_combattant1 = null;
    $image_combattant2 = null;

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

    if ($image && createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $image_combattant1, $image_combattant2, $categorie_id)) {
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
    <title>Ajouter un Combattant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto mt-10 p-5">
    <h2 class="text-xl font-bold mb-5">Ajouter un nouveau combattant</h2>
    <?php if ($error_message): ?>
        <p class="text-red-500"><?= htmlspecialchars($error_message) ?></p>
    <?php elseif ($success_message): ?>
        <p class="text-green-500"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nom" class="block text-sm font-bold mb-2">Nom:</label>
            <input type="text" id="nom" name="nom" required class="w-full p-2 border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label for="prenom" class="block text-sm font-bold mb-2">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required class="w-full p-2 border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-bold mb-2">Description:</label>
            <textarea id="description" name="description" required class="w-full p-2 border border-gray-300 rounded"></textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-sm font-bold mb-2">Image:</label>
            <input type="file" id="image" name="image" required class="w-full p-2 border border-gray-300 rounded">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Ajouter le combattant</button>
    </form>
</div>
</body>
</html>
