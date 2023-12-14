<?php
session_start();
include 'common.php';
include 'admin-functions.php';

// Définition de la fonction validateCombatant
function validateCombatant($nom, $prenom, $description, $image) {
    return !empty($nom) && !empty($prenom) && !empty($description) && !empty($image);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $description = $_POST['description'];
    $image = ""; // Ici, vous devez gérer l'upload de l'image

    if (validateCombatant($nom, $prenom, $description, $image)) {
        if (createCombattant($conn, $nom, $prenom, $description, $image)) {
            header('Location: admin-manage-combattants.php');
            exit();
        }
    } else {
        // Gérer l'erreur de validation
        echo "Les données fournies ne sont pas valides.";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Combattant</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-700 mb-6">Ajouter un nouveau combattant</h1>
    <form action="admin-create-combattant.php" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">Nom:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="nom" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="prenom">Prénom:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="prenom" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description:</label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="description"></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="file" name="image">
        </div>

        <div class="flex items-center justify-between">
            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="Ajouter le combattant">
        </div>
    </form>
</div>
</body>
</html>