<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

// Déplacez la récupération des événements après la soumission du formulaire
$combattants = getAllCombattants($conn);
$categories = getAllCategories($conn);

function handleImageUpload($file, $uploadDirectory = 'image-combattants/') {
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        return 'Erreur lors du téléchargement du fichier.';
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions)) {
        return 'Extension de fichier non autorisée.';
    }

    $uniqueFileName = uniqid('img_', true) . '.' . $extension;
    $destination = $uploadDirectory . $uniqueFileName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        return $destination;
    } else {
        return 'Erreur lors du déplacement du fichier.';
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $nom = $_POST['nom'];
    $date = $_POST['date'];
    $heure = $_POST['heure'];
    $lieu = $_POST['lieu'];
    $description = $_POST['description'];
    $combattant1_id = $_POST['combattant1_id'];
    $combattant2_id = $_POST['combattant2_id'];
    $categorie_id = $_POST['categorie_id'];

    $image_combattant1 = isset($_FILES['image_combattant1']) && !empty($_FILES['image_combattant1']['name']) ? handleImageUpload($_FILES['image_combattant1']) : null;
    $image_combattant2 = isset($_FILES['image_combattant2']) && !empty($_FILES['image_combattant2']['name']) ? handleImageUpload($_FILES['image_combattant2']) : null;

    if ($image_combattant1 === null || $image_combattant2 === null) {
        echo "Erreur lors du téléchargement des images.";
    } else {
        $result = createEvenement($conn, $nom, $date, $heure, $lieu, $description, $combattant1_id, $combattant2_id, $image_combattant1, $image_combattant2, $categorie_id);
        if ($result !== true) {
            echo "Erreur lors de la création de l'événement : " . $result;
        }
    }

    // Recharger les données des événements après la soumission du formulaire
    $evenements = getAllEvenements($conn);
} else {
    // Charger les événements en dehors de la soumission du formulaire
    $evenements = getAllEvenements($conn);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Événements</title>
    <link rel="stylesheet" href="/style/admin-dashboard.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100">
<?php include_once 'admin-sidebar.php'; ?>

<div id="content" class="px-4 md:px-10 py-4 md:py-7">
    <h1 class="text-3xl font-bold mb-6">Gérer les Événements</h1>
    <button id="addEventBtn" class="mb-4 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Ajouter un événement</button>

    <div id="addEventForm" class="hidden bg-gray-800 rounded p-4">
        <form action="admin-manage-events.php" method="post" enctype="multipart/form-data">
            <label class="block text-gray-300">Nom de l'événement:</label>
            <input type="text" name="nom" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1"><br>
            <label class="block text-gray-300 mt-4">Date:</label>
            <input type="date" name="date" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1"><br>
            <label class="block text-gray-300 mt-4">Heure:</label>
            <input type="time" name="heure" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1"><br>
            <label class="block text-gray-300 mt-4">Lieu:</label>
            <input type="text" name="lieu" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1"><br>
            <label class="block text-gray-300 mt-4">Description:</label>
            <textarea name="description" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1"></textarea><br>

            <!-- Champ de sélection pour les combattants -->
            <label class="block text-gray-300 mt-4">Combattant 1:</label>
            <select name="combattant1_id" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1">
                <?php foreach ($combattants as $combattant): ?>
                    <option value="<?= $combattant['id'] ?>"><?= $combattant['nom'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <label class="block text-gray-300 mt-4">Combattant 2:</label>
            <select name="combattant2_id" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1">
                <?php foreach ($combattants as $combattant): ?>
                    <option value="<?= $combattant['id'] ?>"><?= $combattant['nom'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <!-- Champ de sélection pour les catégories -->
            <label class="block text-gray-300 mt-4">Catégorie:</label>
            <select name="categorie_id" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1">
                <?php foreach ($categories as $categorie): ?>
                    <option value="<?= $categorie['id'] ?>"><?= $categorie['nom'] ?></option>
                <?php endforeach; ?>
            </select><br>            <!-- ... -->

            <button type="submit" name="add_event" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mt-4">Ajouter</button>
        </form>
    </div>

    <!-- Affichage des événements -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <?php foreach ($evenements as $evenement): ?>
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-4">
                    <h2 class="text-xl font-bold"><?= $evenement['nom'] ?></h2>
                    <p class="text-gray-500">Date: <?= $evenement['date'] ?>, Heure: <?= $evenement['heure'] ?></p>
                    <p class="mt-2"><?= $evenement['description'] ?></p>
                </div>
                <div class="flex justify-between p-4">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-4 py-2 rounded">Éditer</button>
                    <button class="bg-red-500 hover:bg-red-600 text-white font-bold px-4 py-2 rounded">Supprimer</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.getElementById('addEventBtn').addEventListener('click', function() {
        document.getElementById('addEventForm').classList.toggle('hidden');
    });
</script>
</body>
</html>
