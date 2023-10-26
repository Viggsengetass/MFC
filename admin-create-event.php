<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige si l'utilisateur n'est pas connecté en tant qu'administrateur
    exit();
}

include 'common.php';
include 'config.php';

// Traitement pour ajouter un nouvel événement
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_event'])) {
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $lieu = $_POST['lieu'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $categorie_id = $_POST['categorie_id'];

        // Validez et insérez l'événement dans la base de données
        // Assurez-vous de vérifier les données et d'ajouter des mesures de sécurité.

        // Exemple de requête pour ajouter un événement (veuillez l'adapter à votre base de données)
        $query = "INSERT INTO evenements (nom, date, heure, lieu, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
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
        <li><a href="admin-manage-events.php">Gérer les Événements</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
    </ul>
</div>
<div id="content">
    <h1>Créer un Événement</h1>
    <form method="post" action="admin-create-event.php">
        <label for="nom">Nom de l'Événement :</label>
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
        <input type="text" name="image">
        <br>
        <label for="categorie_id">Catégorie :</label>
        <select name="categorie_id">
            <!-- Options pour les catégories (remplacez par les vôtres) -->
            <option value="1">Catégorie 1</option>
            <option value="2">Catégorie 2</option>
            <option value="3">Catégorie 3</option>
        </select>
        <br>
        <input type="submit" name="add_event" value="Créer l'Événement">
    </form>
</div>
</body>
</html>
