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
<body class="bg-gray-900 text-gray-100">
<div id="sidebar">
    <!-- Include the sidebar here -->
</div>
<div id="content" class="p-4 mt-10">
    <h1 class="text-3xl font-bold mb-6">Gérer les Combattants</h1>

    <button id="addCombatantBtn" class="mb-4 p-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ajouter un combattant</button>

    <div id="addCombatantForm" style="display:none;" class="mb-8 p-6 bg-gray-800 rounded">
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="nom" class="block mb-2">Nom:</label>
                <input type="text" name="nom" id="nom" placeholder="Nom" required class="w-full p-2 border border-gray-700 bg-gray-700 rounded">
            </div>

            <div>
                <label for="prenom" class="block mb-2">Prénom:</label>
                <input type="text" name="prenom" id="prenom" placeholder="Prénom" required class="w-full p-2 border border-gray-700 bg-gray-700 rounded">
            </div>

            <div>
                <label for="surnom" class="block mb-2">Surnom:</label>
                <input type="text" name="surnom" id="surnom" placeholder="Surnom" class="w-full p-2 border border-gray-700 bg-gray-700 rounded">
            </div>

            <div>
                <label for="description" class="block mb-2">Description:</label>
                <textarea name="description" id="description" placeholder="Description" class="w-full p-2 border border-gray-700 bg-gray-700 rounded"></textarea>
            </div>

            <div>
                <label for="image" class="block mb-2">Image:</label>
                <input type="file" name="image" id="image" class="w-full p-2 border border-gray-700 bg-gray-700 rounded">
            </div>

            <div>
                <label for="categorie_id" class="block mb-2">Catégorie ID:</label>
                <input type="number" name="categorie_id" id="categorie_id" placeholder="Catégorie ID" required class="w-full p-2 border border-gray-700 bg-gray-700 rounded">
            </div>

            <div>
                <input type="submit" name="add_combattant" value="Créer le combattant" class="p-2 w-full bg-green-600 text-white rounded hover:bg-green-700 cursor-pointer">
            </div>
        </form>
    </div>

    <!-- Liste des combattants -->
    <div class="grid grid-cols-3 gap-4">
        <?php foreach ($combattants as $combattant): ?>
            <div class="bg-gray-800 p-4 rounded shadow">
                <img class="rounded mb-4" src="<?= htmlspecialchars($combattant['image']) ?>" alt="Image" style="width: 100%; height: 200px; object-fit: cover;">
                <h2 class="text-xl mb-2"><?= htmlspecialchars($combattant['nom']) ?></h2>
                <p class="mb-4"><?= htmlspecialchars($combattant['description']) ?></p>
                <!-- Autres détails du combattant -->
                <div class="flex justify-between">
                    <a href="edit-combattant.php?id=<?= $combattant['id'] ?>" class="text-blue-400 hover:underline">Éditer</a>
                    <a href="delete-combattant.php?id=<?= $combattant['id'] ?>" class="text-red-400 hover:underline">Supprimer</a>
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
