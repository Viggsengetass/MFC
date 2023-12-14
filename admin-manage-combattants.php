<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'admin-functions.php';
require_once 'common.php';

// Vérifiez l'accès administrateur
// checkAdmin();

// Récupération de tous les combattants
$combattants = getAllCombattants($conn);

// Fonction de validation du combattant
function validateCombattant($nom, $prenom, $surnom, $description, $categorie_id, $image) {
    // Effectuez vos validations ici
    // ...
    return true;
}

// Fonction pour créer un combattant dans la base de données
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    // Traitez l'upload de l'image et insérez les données dans la base de données
    // ...
    return true;
}

// Traitement du formulaire d'ajout d'un combattant
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_combattant'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $surnom = $_POST['surnom'];
    $description = $_POST['description'];
    $categorie_id = $_POST['categorie_id'];
    $image = $_FILES['image'];

    // Validation des données
    if (validateCombattant($nom, $prenom, $surnom, $description, $categorie_id, $image)) {
        if (createCombattant($conn, $nom, $prenom, $surnom, $description, $image['name'], $categorie_id)) {
            // Redirection ou affichage d'un message de succès
            echo "Combattant ajouté avec succès.";
        } else {
            echo "Erreur lors de l'ajout du combattant.";
        }
    } else {
        echo "Données du combattant non valides.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les Combattants - Tableau de Bord Administratif</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-200">
<div class="container mx-auto mt-10 p-5">
    <h2 class="text-3xl font-semibold text-gray-800 mb-5">Gérer les Combattants</h2>
    <button id="addCombatantBtn" class="mb-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ajouter un combattant</button>

    <div id="addCombatantForm" class="hidden">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="nom" class="block text-sm font-bold mb-2">Nom :</label>
                <input type="text" id="nom" name="nom" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="prenom" class="block text-sm font-bold mb-2">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="surnom" class="block text-sm font-bold mb-2">Surnom :</label>
                <input type="text" id="surnom" name="surnom" class="w-full p-2 border rounded">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-bold mb-2">Description :</label>
                <textarea id="description" name="description" required class="w-full p-2 border rounded"></textarea>
            </div>
            <div class="mb-4">
                <label for="categorie_id" class="block text-sm font-bold mb-2">Catégorie :</label>
                <select id="categorie_id" name="categorie_id" required class="w-full p-2 border rounded">
                    <!-- Options de catégories ici -->
                </select>
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-bold mb-2">Image :</label>
                <input type="file" id="image" name="image" required class="w-full p-2 border rounded">
            </div>
            <div class="flex justify-end">
                <button type="submit" name="add_combattant" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Créer</button>
            </div>
        </form>
    </div>

    <!-- Affichage des combattants existants -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($combattants as $combattant): ?>
            <!-- Carte du combattant -->
        <?php endforeach; ?>
    </div>
</div>

<script>
    document.getElementById('addCombatantBtn').addEventListener('click', function() {
        var form = document.getElementById('addCombatantForm');
        form.classList.toggle('hidden');
    });
</script>
</body>
</html>
