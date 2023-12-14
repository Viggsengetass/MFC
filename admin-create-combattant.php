<?php
session_start();
include 'common.php'; // Assurez-vous que ce fichier contient la connexion à la base de données et les fonctions partagées
include 'admin-functions.php'; // Ce fichier doit contenir la logique spécifique à l'admin

// Fonction pour valider les données du combattant
function validateCombatant($nom, $prenom, $description, $image) {
    if (empty($nom)) {
        return "Le nom ne peut pas être vide.";
    }
    if (empty($prenom)) {
        return "Le prénom ne peut pas être vide.";
    }
    if (empty($description)) {
        return "La description ne peut pas être vide.";
    }
    if (empty($image)) {
        return "Une image doit être sélectionnée.";
    }
    return true;
}

//checkAdmin(); // Décommentez cette ligne si la fonction checkAdmin est définie et utilisée pour vérifier les permissions

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image']['name'] ?? ''; // Ajustez la logique de téléchargement d'image selon vos besoins

    // Valider les données reçues
    $validationResult = validateCombatant($nom, $prenom, $description, $image);
    if ($validationResult === true) {
        // Votre logique pour créer un combattant ici
        if (createCombattant($nom, $prenom, $description, $image)) {
            header('Location: admin-manage-combattants.php');
            exit();
        } else {
            $error_message = "Erreur lors de la création du combattant.";
        }
    } else {
        $error_message = $validationResult;
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