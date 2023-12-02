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
        $image = $_POST['image'];
        $categorie_id = $_POST['categorie_id'];

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

// Récupérez la liste des événements depuis la base de données (exemples fictifs)
$query = "SELECT * FROM evenements_admin";
$result = $conn->query($query);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Événements - Tableau de Bord Administratif</title>
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
    <h1>Gérer les Événements</h1>
    <h2>Ajouter un nouvel événement</h2>
    <form method="post" action="admin-manage-events.php">
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
        <input type="submit" name="add_event" value="Ajouter l'événement">
    </form>
    <!-- Liste des événements existants -->
    <h2>Liste des Événements</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Date</th>
            <th>Heure</th>
            <th>Lieu</th>
            <th>Description</th>
            <th>Image</th>
            <th>Catégorie</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($events as $event) : ?>
            <tr>
                <td><?= $event['nom'] ?></td>
                <td><?= $event['date'] ?></td>
                <td><?= $event['heure'] ?></td>
                <td><?= $event['lieu'] ?></td>
                <td><?= $event['description'] ?></td>
                <td><img src="<?= $event['image'] ?>" alt="Image de l'événement"></td>
                <td><?= $event['categorie_id'] ?></td>
                <td>
                    <a href="edit-event.php?id=<?= $event['id'] ?>">Éditer</a> |
                    <a href="delete-event.php?id=<?= $event['id'] ?>">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
