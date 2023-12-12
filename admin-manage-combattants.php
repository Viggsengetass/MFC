<?php
session_start();
require_once 'admin-functions.php';
include 'common.php';

// Ici, vous pouvez définir votre logique pour vérifier si l'utilisateur est un admin
// Cette vérification est désactivée pour le développement

$error_message = ""; // Initialisez la variable d'erreur

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] == 'create_combattant') {
        // Collecter les données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $surnom = $_POST['surnom'];
        $description = $_POST['description'];
        $categorie_id = $_POST['categorie_id'];

        // Gérez le téléchargement de l'image du combattant s'il est nécessaire
        $image = null; // Si aucune image n'est téléchargée par défaut
        if (!empty($_FILES['image']['name'])) {
            $image = "uploads/" . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }

        // Appeler la fonction pour créer un combattant
        if (createCombattant($nom, $prenom, $surnom, $description, $image, $categorie_id, $conn)) {
            // Combattant créé avec succès
            header('Location: admin-manage-combattants.php?success=1');
        } else {
            // Échec de la création du combattant
            $error_message = "Erreur lors de l'ajout du combattant.";
        }
    }
}

$combattants = getAllCombattants($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Combattants - Tableau de Bord Administratif</title>
    <link rel="stylesheet" href="admin-dashboard.css">
</head>
<body>
<?php include 'admin-sidebar.php'; ?>
<div id="content">
    <h1>Gérer les Combattants</h1>

    <?php
    if (!empty($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    if (isset($_GET['success'])) {
        echo "<p style='color: green;'>Combattant ajouté avec succès!</p>";
    }
    ?>

    <form method="post" action="admin-manage-combattants.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create_combattant">
        <!-- Ajoutez ici les champs pour nom, prénom, etc. -->
        <!-- ... -->
        <input type="submit" value="Ajouter le combattant">
    </form>

    <!-- Liste des combattants existants -->
    <h2>Liste des Combattants</h2>
    <ul>
        <?php foreach ($combattants as $combattant) : ?>
            <li><?= htmlspecialchars($combattant['prenom']) . ' ' . htmlspecialchars($combattant['nom']) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
