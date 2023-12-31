<?php
session_start();

// Incluez le fichier de configuration de la base de données
include 'config.php';
include 'admin-functions.php'; // Assurez-vous d'inclure le fichier admin-functions.php

// Vérifie si l'utilisateur est connecté en tant qu'administrateur
if (!isAdmin()) {
    // Redirige ou effectue une autre action en cas d'accès non autorisé
    header('Location: unauthorized.php');
    exit();
}

// Traitement pour ajouter un nouvel événement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_event'])) {
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $lieu = $_POST['lieu'];
        $description = $_POST['description'];
        $categorie_id = $_POST['categorie_id'];

        // Gérez le téléchargement de l'image de l'événement s'il est nécessaire
        $image = null; // Initialisez à null par défaut

        if (!empty($_FILES['image']['name'])) {
            $image = "uploads/" . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }

        // Validez et insérez l'événement dans la base de données
        // Assurez-vous de vérifier les données et d'ajouter des mesures de sécurité.

        // Exemple de requête pour ajouter un événement (veuillez l'adapter à votre base de données)
        $query = "INSERT INTO evenements_admin (nom, date, heure, lieu, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("ssssssi", $nom, $date, $heure, $lieu, $description, $image, $categorie_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Événement - Tableau de Bord Administratif</title>
    <link rel="stylesheet" href="admin-dashboard.css">
</head>
<body>
<div id="sidebar">
    <ul>
        <li><a href="admin-dashboard.php">Tableau de Bord</a></li>
        <li><a href="admin-manage-combattants.php">Gérer les Combattants</a></li>
        <li><a href="admin-create-event.php">Créer un Événement</a></li>
        <li><a href="admin-list-events.php">Liste des Événements</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
    </ul>
</div>
<div id="content">
    <h1>Créer un Événement</h1>
    <form method="post" action="admin-create-event.php" enctype="multipart/form-data">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required>
        <br>
        <label for="date">Date :</label>
        <input type="date" name="date" required>
        <br>
        <label for="heure">Heure :</label>
        <input type="time" name="heure" required>
        <br>
        <label for="lieu">Lieu :</label>
        <input type="text" name="lieu" required>
        <br>
        <label for="description">Description :</label>
        <textarea name="description" rows="4"></textarea>
        <br>
        <label for="image">Image (URL) :</label>
        <input type="file" name="image">
        <br>
        <label for="categorie_id">Catégorie :</label>
        <select name="categorie_id">
            <!-- Options pour les catégories (remplacez par les vôtres) -->
            <option value="1">Catégorie 1</option>
            <option value="2">Catégorie 2</option>
            <option value="3">Catégorie 3</option>
        </select>
        <br>
        <input type="submit" name="add_event" value="Ajouter l'événement">
    </form>
</div>
</body>
</html>
