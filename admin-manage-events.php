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
        // Cette fonction doit être définie pour traiter les fichiers d'upload et retourner le chemin de l'image ou une erreur
        $image_combattant1 = handleImageUpload($_FILES['image_combattant1']);
        $image_combattant2 = handleImageUpload($_FILES['image_combattant2']);

        createEvenement($conn, $nom, $date, $heure, $lieu, $description, $combattant1_id, $combattant2_id, $image_combattant1, $image_combattant2);
    }
    // Les sections pour 'edit_event' et 'delete_event' doivent être complétées de manière similaire
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
    <button id="addEventBtn" class="mb-4">Ajouter un événement</button>

    <!-- Formulaire pour ajouter un événement -->
    <div id="addEventForm" class="hidden">
        <form action="admin-manage-event.php" method="post" enctype="multipart/form-data">
            <label for="nom">Nom de l'événement:</label>
            <input type="text" name="nom" required><br>

            <label for="date">Date:</label>
            <input type="date" name="date" required><br>

            <label for="heure">Heure:</label>
            <input type="time" name="heure" required><br>

            <label for="lieu">Lieu:</label>
            <input type="text" name="lieu" required><br>

            <label for="description">Description:</label>
            <textarea name="description" required></textarea><br>

            <label for="combattant1_id">Combattant 1:</label>
            <select name="combattant1_id" required>
                <?php foreach ($combattants as $combattant): ?>
                    <option value="<?= $combattant['id'] ?>"><?= $combattant['nom'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="combattant2_id">Combattant 2:</label>
            <select name="combattant2_id" required>
                <?php foreach ($combattants as $combattant): ?>
                    <option value="<?= $combattant['id'] ?>"><?= $combattant['nom'] ?></option>
                <?php endforeach; ?>
            </select><br>

            <label for="image_combattant1">Image du Combattant 1:</label>
            <input type="file" name="image_combattant1" accept="image/*" required><br>

            <label for="image_combattant2">Image du Combattant 2:</label>
            <input type="file" name="image_combattant2" accept="image/*" required><br>

            <button type="submit" name="add_event">Ajouter</button>
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
