<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

$evenements = getAllEvenements($conn);
$combattants = getAllCombattants($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_event'])) {
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $lieu = $_POST['lieu'];
        $description = $_POST['description'];
        $combattant1_id = $_POST['combattant1_id'];
        $combattant2_id = $_POST['combattant2_id'];

        // Gérer l'upload des images pour les combattants
        $image_combattant1 = handleImageUpload($_FILES['image_combattant1']);
        $image_combattant2 = handleImageUpload($_FILES['image_combattant2']);

        // Vérifier s'il y a eu une erreur lors du téléchargement des images
        if (!is_string($image_combattant1) || !is_string($image_combattant2)) {
            // Une erreur s'est produite lors du téléchargement des images, vous pouvez afficher un message d'erreur.
            echo "Erreur lors du téléchargement des images : " . $image_combattant1 . " " . $image_combattant2;
        } else {
            // Les images ont été téléchargées avec succès, vous pouvez continuer à ajouter l'événement.
            $result = createEvenement($conn, $nom, $date, $heure, $lieu, $description, $combattant1_id, $combattant2_id, $image_combattant1, $image_combattant2);
            if ($result !== true) {
                echo "Erreur lors de la création de l'événement : " . $result;
            }
        }
    }
    // Implémenter la logique pour 'edit_event' et 'delete_event'
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

    <!-- Formulaire pour ajouter un événement -->
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

            <label class="block text-gray-300 mt-4">Image du Combattant 1:</label>
            <input type="file" name="image_combattant1" accept="image/*" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1"><br>

            <label class="block text-gray-300 mt-4">Image du Combattant 2:</label>
            <input type="file" name="image_combattant2" accept="image/*" required class="w-full bg-gray-700 text-white px-4 py-2 rounded mt-1"><br>

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
