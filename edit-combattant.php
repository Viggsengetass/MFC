<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

$combattantId = $_GET['id'] ?? null;
$combattant = $combattantId ? getCombattant($conn, $combattantId) : null;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_combattant'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $surnom = $_POST['surnom'] ?? '';
    $description = $_POST['description'] ?? '';
    $categorie_id = $_POST['categorie_id'] ?? 0;

    $image = $combattant['image']; // Utiliser l'image existante par défaut
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $targetDirectory = "/var/www/vhosts/nice-meitner.164-90-190-187.plesk.page/httpdocs/image-combattants/";
        $targetFile = $targetDirectory . basename($_FILES['image']['name']);
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = "image-combattants/" . basename($_FILES['image']['name']);
        } else {
            echo "<p>Erreur lors du téléchargement de l'image.</p>";
        }
    }

    if (updateCombattant($conn, $combattantId, $nom, $prenom, $surnom, $description, $image, $categorie_id)) {
        header('Location: admin-manage-combattants.php');
        exit();
    } else {
        $error_message = "Erreur lors de la mise à jour du combattant.";
    }
}

if (!$combattantId || !$combattant) {
    header('Location: admin-manage-combattants.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Combattant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">
<div class="flex justify-center min-h-screen items-center">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-white">
                Éditer Combattant
            </h2>
            <?php if (!empty($error_message)): ?>
                <div class="bg-red-600 text-white p-3 rounded mb-4">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>
        </div>
        <form class="mt-8 space-y-6" action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $combattantId ?>">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="nom" class="sr-only">Nom</label>
                    <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($combattant['nom']) ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Nom">
                </div>
                <div>
                    <label for="prenom" class="sr-only">Prénom</label>
                    <input type="text" name="prenom" id="prenom" value="<?= htmlspecialchars($combattant['prenom']) ?>" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Prénom">
                </div>
                <div>
                    <label for="surnom" class="sr-only">Surnom</label>
                    <input type="text" name="surnom" id="surnom" value="<?= htmlspecialchars($combattant['surnom']) ?>" class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm" placeholder="Surnom">
                </div>
                <div>
                    <label for="description" class="sr-only">Description</label>
                    <textarea name="description" id="description" rows="3" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Description"><?= htmlspecialchars($combattant['description']) ?></textarea>
                </div>
                <div>
                    <label for="image" class="block mb-2 text-sm font-medium text-gray-300">Image actuelle:</label>
                    <img src="<?= htmlspecialchars($combattant['image']) ?: 'path/to/default-image.png' ?>" alt="Image actuelle" class="w-32 h-32 object-cover mb-2">
                    <input type="file" name="image" id="image" class="bg-gray-800 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100">
                </div>
            </div>

            <div>
                <button type="submit" name="update_combattant" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
