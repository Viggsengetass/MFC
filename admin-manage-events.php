<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

$evenements = getAllEvenements($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_event'])) {
        // Code pour ajouter un nouvel événement
    } elseif (isset($_POST['edit_event'])) {
        // Code pour éditer un événement existant
    } elseif (isset($_POST['delete_event'])) {
        // Code pour supprimer un événement
    }
}

function getAllEvenements($conn) {
    // Implémenter la récupération de tous les événements
}

function createEvenement($conn, $nom, $date, $heure, $lieu, $description, $image) {
    // Implémenter la création d'un événement
}

function editEvenement($conn, $id, $nom, $date, $heure, $lieu, $description, $image) {
    // Implémenter la modification d'un événement
}

function deleteEvenement($conn, $id) {
    // Implémenter la suppression d'un événement
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Événements</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Styles personnalisés ici */
    </style>
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
            <input type="file" name="image">
            <button type="submit" name="add_event">Ajouter</button>
        </form>
    </div>

    <!-- Affichage des événements -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        <?php foreach ($evenements as $evenement): ?>
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                <img src="<?= htmlspecialchars($evenement['image']) ?>" alt="<?= htmlspecialchars($evenement['nom']) ?>" class="w-full h-60 object-cover">
                <div class="p-5">
                    <h2 class="text-2xl font-semibold"><?= htmlspecialchars($evenement['nom']) ?></h2>
                    <p><?= htmlspecialchars($evenement['description']) ?></p>
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
