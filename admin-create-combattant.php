<?php
session_start();
require_once 'common.php'; // Ce fichier doit inclure la connexion à la base de données et des fonctions communes
require_once 'admin-functions.php'; // Ce fichier doit inclure des fonctions spécifiques à l'administration comme checkAdmin

// Fonction pour valider les données du combattant
function validateCombatant($nom, $prenom, $description, $image) {
    if (empty($nom) || empty($prenom) || empty($description)) {
        return "Le nom, le prénom et la description ne peuvent pas être vides.";
    }
    if (empty($image)) {
        return "Vous devez sélectionner une image.";
    }
    // Effectuez ici d'autres validations au besoin
    return true;
}

// Fonction pour créer un combattant dans la base de données
function createCombattant($conn, $nom, $prenom, $description, $imagePath) {
    $stmt = $conn->prepare("INSERT INTO combattants (nom, prenom, description, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $prenom, $description, $imagePath);
    $success = $stmt->execute();
    $stmt->close();
    return $success;
}

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = getDatabaseConnection(); // Assurez-vous que cette fonction existe et retourne une connexion valide à la base de données

    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image']['name'] ?? '';

    $validationResult = validateCombatant($nom, $prenom, $description, $image);
    if ($validationResult === true) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            if (createCombattant($conn, $nom, $prenom, $description, $targetFile)) {
                $success_message = "Combattant ajouté avec succès.";
            } else {
                $error_message = "Erreur lors de l'ajout dans la base de données.";
            }
        } else {
            $error_message = "Erreur lors du téléchargement de l'image.";
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
<div class="container mx-auto mt-10 p-5">
    <h2 class="text-xl font-bold mb-5">Ajouter un nouveau combattant</h2>
    <?php if ($error_message): ?>
        <p class="text-red-500"><?= htmlspecialchars($error_message) ?></p>
    <?php elseif ($success_message): ?>
        <p class="text-green-500"><?= htmlspecialchars($success_message) ?></p>
    <?php endif; ?>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
        <div class="mb-4">
            <label for="nom" class="block text-sm font-bold mb-2">Nom:</label>
            <input type="text" id="nom" name="nom" required class="w-full p-2 border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label for="prenom" class="block text-sm font-bold mb-2">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required class="w-full p-2 border border-gray-300 rounded">
        </div>
        <div class="mb-4">
            <label for="description" class="block text-sm font-bold mb-2">Description:</label>
            <textarea id="description" name="description" required class="w-full p-2 border border-gray-300 rounded"></textarea>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-sm font-bold mb-2">Image:</label>
            <input type="file" id="image" name="image" required class="w-full p-2 border border-gray-300 rounded">
        </div>
        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Ajouter le combattant</button>
    </form>
</div>
</body>
</html>
