<?php
session_start();
include 'config.php';
include 'admin-functions.php';
checkAdmin(); // Assurez-vous que seul un admin peut accéder à cette page

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assurez-vous que les données POST sont désinfectées
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $description = $_POST['description'];
    $image = ""; // Remplacez cela par la logique de téléchargement d'image

    // Vérifiez ici que les données reçues sont valides avant de les insérer dans la base de données
    if (validateCombatant($nom, $prenom, $description, $image, $conn)) {
        if (createCombattant($conn, $nom, $prenom, $description, $image)) {
            // Redirection après la création réussie
            header('Location: admin-manage-combattants.php');
            exit();
        }
    }
    // Gérez ici les erreurs si les données ne sont pas valides ou si la création échoue
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Combattant</title>
    <!-- Inclure ici vos liens CSS -->
</head>
<body>
<div id="content">
    <h1>Ajouter un nouveau combattant</h1>
    <form action="admin-create-combattant.php" method="post" enctype="multipart/form-data">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" required><br>

        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" required><br>

        <label for="description">Description:</label>
        <textarea name="description"></textarea><br>

        <label for="image">Image:</label>
        <input type="file" name="image"><br>

        <input type="submit" value="Ajouter le combattant">
    </form>
</div>
</body>
</html>
