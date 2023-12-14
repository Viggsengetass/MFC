<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

$evenements = getAllEvenements($conn);
$combattants = getAllCombattants($conn); // Assurez-vous d'avoir cette fonction dans admin-functions.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_event'])) {
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $lieu = $_POST['lieu'];
        $description = $_POST['description'];
        $combattant1_id = $_POST['combattant1_id'];
        $combattant2_id = $_POST['combattant2_id'];

        createEvenement($nom, $date, $heure, $lieu, $description, $combattant1_id, $combattant2_id, $conn);
    } elseif (isset($_POST['edit_event'])) {
        // Logique pour éditer un événement
    } elseif (isset($_POST['delete_event'])) {
        // Logique pour supprimer un événement
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Événements</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-gray-100">
<?php include_once 'admin-sidebar.php'; ?>

<div id="content" class="px-4 md:px-10 py-4 md:py-7">
    <h1 class="text-3xl font-bold mb-6">Gérer les Événements</h1>
    <button id="addEventBtn">Ajouter un événement</button>

    <!-- Formulaire pour ajouter un événement -->
    <div id="addEventForm" class="hidden">
        <form action="admin-manage-event.php" method="post" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Nom de l'événement" required>
            <input type="date" name="date" required>
            <input type="time" name="heure" required>
            <input type="text" name="lieu" placeholder="Lieu" required>
            <textarea name="description" placeholder="Description"></textarea>
            <select name="combattant1_id" required>
                <?php foreach ($combattants as $combattant): ?>
                    <option value="<?= $combattant['id'] ?>"><?= $combattant['nom'] ?></option>
                <?php endforeach; ?>
            </select>
            <select name="combattant2_id" required>
                <?php foreach ($combattants as $combattant): ?>
                    <option value="<?= $combattant['id'] ?>"><?= $combattant['nom'] ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" name="add_event">Ajouter</button>
        </form>
    </div>

    <!-- Affichage des événements -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <?php foreach ($evenements as $evenement): ?>
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <div class="p-5">
                    <h2 class="text-2xl font-semibold"><?= htmlspecialchars($evenement['nom']) ?></h2>
                    <p><?= htmlspecialchars($evenement['description']) ?></p>
                    <img src="<?= getCombattantImage($evenement['combattant1_id'], $conn) ?>" alt="Combattant 1">
                    <img src="<?= getCombattantImage($evenement['combattant2_id'], $conn) ?>" alt="Combattant 2">
                    <!-- Boutons d'édition et de suppression -->
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
