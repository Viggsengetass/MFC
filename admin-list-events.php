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

// Sélectionnez tous les événements depuis la base de données
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
    <title>Liste des Événements - Tableau de Bord Administratif</title>
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
    <h1>Liste des Événements</h1>
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
