<?php
session_start();

// Supposons que common.php contient la fonction pour obtenir une connexion à la base de données
require_once 'common.php';

// Fonction pour valider les données du combattant
function validateCombatant($nom, $prenom, $description, $image) {
    // Vérifiez si les champs nom, prénom et description ne sont pas vides
    if (empty($nom) || empty($prenom) || empty($description)) {
        return "Le nom, le prénom et la description ne peuvent pas être vides.";
    }

    // Vérifiez si un fichier image a été téléchargé
    if (empty($image)) {
        return "Vous devez sélectionner une image.";
    }

    // Ajoutez ici d'autres règles de validation si nécessaire

    return true; // Retourne true si toutes les validations sont passées
}

// Fonction pour créer un combattant dans la base de données
function createCombattant($conn, $nom, $prenom, $description, $image) {
    // Gestion du téléchargement d'image
    $targetDir = "uploads/"; // Assurez-vous que ce répertoire existe et est accessible en écriture
    $targetFile = $targetDir . basename($image);

    // Déplacer le fichier téléchargé vers le répertoire de destination
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Préparation de la requête SQL pour insérer les données
        $stmt = $conn->prepare("INSERT INTO combattants (nom, prenom, description, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nom, $prenom, $description, $targetFile);

        // Exécution de la requête
        $result = $stmt->execute();

        // Fermeture de la déclaration
        $stmt->close();

        return $result; // Retourne le résultat de l'exécution de la requête
    }

    return false; // Retourne false si l'image n'a pas pu être téléchargée
}

$error_message = '';

// Traitement du formulaire lorsqu'il est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $conn = getDatabaseConnection();

    // Collecte des données du formulaire
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image']['name'] ?? '';

    // Validation des données
    $validationResult = validateCombatant($nom, $prenom, $description, $image);
    if ($validationResult === true) {
        // Création du combattant si les données sont valides
        if (createCombattant($conn, $nom, $prenom, $description, $image)) {
            // Redirection vers la page de gestion des combattants
            header('Location: admin-manage-combattants.php');
            exit();
        } else {
            // Message d'erreur en cas d'échec de création
            $error_message = "Erreur lors de la création du combattant.";
        }
    } else {
        // Message d'erreur si les données ne sont pas valides
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
            <?= $error_message ?>
        </div>
    <?php endif; ?>
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
