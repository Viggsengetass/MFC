<?php
session_start();

// Supposons que common.php contienne la fonction pour obtenir une connexion à la base de données
require_once 'common.php';
require_once 'admin-functions.php'; // Ce fichier doit contenir les fonctions spécifiques à l'administration, telles que checkAdmin

// Fonction pour valider les données du combattant
function validateCombatant($nom, $prenom, $description, $image) {
    if (empty($nom) || empty($prenom) || empty($description)) {
        return "Le nom, le prénom et la description sont obligatoires.";
    }
    if (empty($image)) {
        return "Une image doit être sélectionnée.";
    }
    // Ajoutez d'autres règles de validation si nécessaire
    return true;
}

// Fonction pour créer un combattant dans la base de données
function createCombattant($conn, $nom, $prenom, $description, $image) {
    $targetDir = "uploads/"; // Ce répertoire doit être présent et accessible en écriture sur le serveur
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO combattants (nom, prenom, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $prenom, $description, $targetFile);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    } else {
        return "Erreur lors du téléchargement de l'image.";
    }
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = getDatabaseConnection(); // Assurez-vous que cette fonction retourne une connexion valide à la base de données
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image']['name'] ?? '';

    $validationResult = validateCombatant($nom, $prenom, $description, $image);
    if ($validationResult === true) {
        $creationResult = createCombattant($conn, $nom, $prenom, $description, $image);
        if ($creationResult === true) {
            header('Location: admin-manage-combattants.php');
            exit();
        } else {
            $error_message = $creationResult; // Si createCombattant retourne un message d'erreur
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
    <?php if ($error_message): ?>
        <div class="mb-4 text-red-500">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>
    <form action="admin-create-combattant.php" method="post" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="nom">Nom :</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="nom" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="prenom">Prénom :</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="text" name="prenom" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description :</label>
            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="description"></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="image">Image :</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="file" name="image" required>
        </div>
        <div class="flex items-center justify-between">
            <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit" value="Ajouter le combattant">
        </div>
    </form>
</div>
</body>
</html>
