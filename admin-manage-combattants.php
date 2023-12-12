<?php
// session_start(); // Uncomment if you use sessions
require_once 'admin-functions.php';
require_once 'common.php';

// Ensure the user is an administrator
// checkAdmin();

$combattants = getAllCombattants($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_combattant'])) {
    // Process the form data and add a new combatant
    // Remember to validate and sanitize input data
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Combattants - Tableau de Bord Administratif</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Add Tailwind CSS configuration here if needed
    </script>
</head>
<body class="bg-gray-100">
<div id="sidebar">
    <!-- Include the sidebar here -->
</div>
<div id="content" class="p-4">
    <h1 class="text-2xl font-bold mb-4">Gérer les Combattants</h1>

    <button id="addCombatantBtn" class="mb-4 p-2 bg-blue-500 text-white rounded hover:bg-blue-600">Ajouter un combattant</button>

    <div id="addCombatantForm" style="display:none;" class="mb-8">
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="nom" placeholder="Nom" required class="mb-2 p-2 border border-gray-300 rounded">
            <input type="text" name="prenom" placeholder="Prénom" required class="mb-2 p-2 border border-gray-300 rounded">
            <input type="text" name="surnom" placeholder="Surnom" class="mb-2 p-2 border border-gray-300 rounded">
            <textarea name="description" placeholder="Description" class="mb-2 p-2 border border-gray-300 rounded"></textarea>
            <input type="file" name="image" class="mb-2">
            <input type="number" name="categorie_id" placeholder="Catégorie ID" required class="mb-2 p-2 border border-gray-300 rounded">
            <input type="submit" name="add_combattant" value="Créer le combattant" class="p-2 bg-green-500 text-white rounded hover:bg-green-600">
        </form>
    </div>

    <!-- Liste des combattants -->
    <div class="grid grid-cols-3 gap-4">
        <?php foreach ($combattants as $combattant): ?>
            <div class="bg-white p-4 rounded shadow">
                <img class="rounded" src="<?= htmlspecialchars($combattant['image']) ?>" alt="Image" style="width: 100px; height: 100px; object-fit: cover;">
                <h2 class="text-xl"><?= htmlspecialchars($combattant['nom']) ?></h2>
                <!-- Autres détails du combattant -->
                <div class="mt-4">
                    <a href="edit-combattant.php?id=<?= $combattant['id'] ?>" class="text-blue-500 hover:underline">Éditer</a>
                    <a href="delete-combattant.php?id=<?= $combattant['id'] ?>" class="text-red-500 hover:underline">Supprimer</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    // JavaScript to toggle the add combatant form
    document.getElementById('addCombatantBtn').addEventListener('click', function() {
        var form = document.getElementById('addCombatantForm');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    });
</script>
</body>
</html>
