<?php
session_start();
require_once 'admin-functions.php'; // Inclure les fonctions communes d'administration
include 'config.php';

// Vérifier si l'utilisateur est connecté en tant qu'administrateur
checkAdmin();

// Traitement pour ajouter un nouveau combattant
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_combattant'])) {
        $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
        $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
        $surnom = filter_input(INPUT_POST, 'surnom', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $image = filter_input(INPUT_POST, 'image', FILTER_SANITIZE_URL);
        $categorie_id = filter_input(INPUT_POST, 'categorie_id', FILTER_VALIDATE_INT);

        // Valider et insérer le combattant dans la base de données
        if (validateCombatant($nom, $prenom, $description, $image, $categorie_id)) {
            if (insertCombatant($nom, $prenom, $surnom, $description, $image, $categorie_id)) {
                header('Location: admin-manage-combattants.php');
                exit();
            } else {
                $error_message = "Erreur lors de l'ajout du combattant.";
            }
        } else {
            $error_message = "Veuillez remplir tous les champs obligatoires.";
        }
    }
}

// Récupérer la liste des combattants depuis la base de données
$combattants = getCombatants($conn);
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
<div id="sidebar">
    <?php include 'admin-sidebar.php'; ?>
</div>
<div id="content">
    <h1>Gérer les Combattants</h1>
    <h2>Ajouter un nouveau combattant</h2>
    <?php
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>
    <form method="post" action="admin-manage-combattants.php">
        <!-- Formulaire pour ajouter un combattant -->
        <!-- ... (comme dans votre code existant) ... -->
    </form>
    <!-- Liste des combattants existants -->
    <h2>Liste des Combattants</h2>
    <ul>
        <?php foreach ($combattants as $combattant) : ?>
            <li><?= $combattant['prenom'] . ' ' . $combattant['nom'] ?></li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
