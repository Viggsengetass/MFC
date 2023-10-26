<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige si l'utilisateur n'est pas connecté en tant qu'administrateur
    exit();
}

include 'common.php';
include 'config.php';

// Sélectionnez tous les événements depuis la base de données (veuillez adapter la requête à votre base de données)
$query = "SELECT * FROM evenements";
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
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
