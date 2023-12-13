<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

// Vérifiez que l'ID du combattant est passé en paramètre dans l'URL
if (!isset($_GET['id'])) {
    die('Un identifiant de combattant est nécessaire pour éditer.');
}

$combattantId = $_GET['id'];
$combattant = getCombattant($conn, $combattantId);

if (!$combattant) {
    die('Combattant non trouvé.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_combattant'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $surnom = $_POST['surnom'];
    $description = $_POST['description'];
    $image = $combattant['image']; // Utiliser l'image existante par défaut

    // Traitement de l'image téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDirectory = "/var/www/vhosts/nice-meitner.164-90-190-187.plesk.page/httpdocs/image-combattants/";
        $targetFile = $targetDirectory . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = "image-combattants/" . basename($_FILES['image']['name']);
        } else {
            echo "<p>Erreur lors du téléchargement de l'image.</p>";
        }
    }

    // Mise à jour du combattant dans la base de données
    if (updateCombattant($conn, $combattantId, $nom, $prenom, $surnom, $description, $image)) {
        echo "<p>Combattant mis à jour avec succès.</p>";
        $combattant = getCombattant($conn, $combattantId); // Actualiser les données du combattant
    } else {
        echo "<p>Erreur lors de la mise à jour du combattant.</p>";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer Combattant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100">
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-4">Éditer le Combattant</h1>
    <form method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="mb-4">
            <label for="nom" class="block text-gray-300 mb-1">Nom:</label>
            <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($combattant['nom']) ?>" class="w-full p-2 bg-gray-800 border border-gray-600 rounded" required>
        </div>
        <div class="mb-4">
            <label for="prenom" class="block text-gray-300 mb-1">Prénom:</label>
            <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($combattant['prenom']) ?>" class="w-full p-2 bg-gray-800 border border-gray-600 rounded" required>
        </div>
        <div class="mb-4">
            <label for="surnom" class="block text-gray-300 mb-1">Surnom:</label>
            <input type="text" id="surnom" name="surnom" value="<?= htmlspecialchars($combattant['surnom']) ?>" class="w-full p-2 bg-gray-800 border border-gray-600 rounded">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-300 mb-1">Description:</label>
            <textarea id="description" name="description" rows="4" class="w-full p-2 bg-gray-800 border border-gray-600 rounded"><?= htmlspecialchars($combattant['description']) ?></textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-300 mb-1">Image actuelle:</label>
            <img src="<?= htmlspecialchars($combattant['image']) ?: 'path/to/default-image.png' ?>" alt="Image actuelle" class="w-32 h-32 object-cover mb-2">
            <input type="file" id="image" name="image" class="w-full p-2 bg-gray-800 border border-gray-600 rounded">
        </div>
        <button type="submit" name="update_combattant" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded">Mettre à jour</button>
    </form>
    <a href="admin-manage-combattants.php" class="text-blue-300 hover:underline">Retour à la liste des combattants</a>
</div>
<script>
    // Code JavaScript si nécessaire
</script>
</body>
</html>
