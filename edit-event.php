<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige si l'utilisateur n'est pas connecté en tant qu'administrateur
    exit();
}

include 'config.php';

// Fonction pour obtenir les détails d'un événement
function getEventDetails($event_id, $conn) {
    $query = "SELECT * FROM evenements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fonction pour mettre à jour les détails d'un événement
function updateEvent($event_id, $nom, $date, $heure, $lieu, $description, $image, $categorie_id, $conn) {
    $query = "UPDATE evenements SET nom = ?, date = ?, heure = ?, lieu = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $date, $heure, $lieu, $description, $image, $categorie_id, $event_id);
    return $stmt->execute();
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $event = getEventDetails($event_id, $conn);

    if (!$event) {
        // Gérez le cas où l'événement n'est pas trouvé
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $lieu = $_POST['lieu'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $categorie_id = $_POST['categorie_id'];

        if (updateEvent($event_id, $nom, $date, $heure, $lieu, $description, $image, $categorie_id, $conn)) {
            header('Location: admin-list-events.php'); // Redirige après la mise à jour
            exit();
        } else {
            // Gérez le cas où la mise à jour a échoué
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer un Événement - Tableau de Bord Administratif</title>
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
    <h1>Éditer un Événement</h1>
    <form method="post" action="edit-event.php?id=<?= $event_id ?>">
        <label for="nom">Nom de l'Événement :</label>
        <input type="text" name="nom" value="<?= $event['nom'] ?>" required>
        <br>
        <label for="date">Date :</label>
        <input type="date" name="date" value="<?= $event['date'] ?>" required>
        <br>
        <label for="heure">Heure :</label>
        <input type="time" name="heure" value="<?= $event['heure'] ?>" required>
        <br>
        <label for="lieu">Lieu :</label>
        <input type="text" name="lieu" value="<?= $event['lieu'] ?>" required>
        <br>
        <label for="description">Description :</label>
        <textarea name="description" rows="4"><?= $event['description'] ?></textarea>
        <br>
        <label for="image">Image (URL) :</label>
        <input type="text" name="image" value="<?= $event['image'] ?>">
        <br>
        <label for="categorie_id">Catégorie :</label>
        <select name="categorie_id">
            <!-- Options pour les catégories (remplacez par les vôtres) -->
            <option value="1" <?= ($event['categorie_id'] == 1) ? "selected" : "" ?>>Catégorie 1</option>
            <option value="2" <?= ($event['categorie_id'] == 2) ? "selected" : "" ?>>Catégorie 2</option>
            <option value="3" <?= ($event['categorie_id'] == 3) ? "selected" : "" ?>>Catégorie 3</option>
        </select>
        <br>
        <input type="submit" name="update_event" value="Mettre à jour l'Événement">
    </form>
</div>
</body>
</html>
