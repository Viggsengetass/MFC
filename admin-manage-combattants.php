<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige si l'utilisateur n'est pas connecté en tant qu'administrateur
    exit();
}

include 'common.php';
include 'config.php';

// Traitement pour ajouter un nouveau combattant
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_combattant'])) {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $surnom = $_POST['surnom'];
        $description = $_POST['description'];
        $image = $_POST['image'];
        $categorie_id = $_POST['categorie_id'];

        // Validez et insérez le combattant dans la base de données
        // Assurez-vous de vérifier les données et d'ajouter des mesures de sécurité.

        // Exemple de requête pour ajouter un combattant (veuillez l'adapter à votre base de données)
        $query = "INSERT INTO combattants (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if ($stmt) {
            $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
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
    <title>Gérer les Combattants - Tableau de Bord Administratif</title>
    <link rel="stylesheet" href="admin-dashboard.css">
</head>
<body>
<div id="sidebar">
    <ul>
        <li><a href="admin-dashboard.php">Tableau de Bord</a></li>
        <li><a href="admin-manage-combattants.php">Gérer les Combattants</a></li>
        <li><a href="admin-manage-events.php">Gérer les Événements</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
    </ul>
</div>
<div id="content">
    <h1>Gérer les Combattants</h1>
    <h2>Ajouter un nouveau combattant</h2>
    <form method="post" action="admin-manage-combattants.php">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required>
        <br>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" required>
        <br>
        <label for="surnom">Surnom :</label>
        <input type="text" name="surnom">
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
        <input type="submit" name="add_combattant" value="Ajouter le combattant">
    </form>
    <!-- Liste des combattants existants (affichez les combattants à partir de la base de données) -->
    <h2>Liste des Combattants</h2>
    <ul>
        <!-- Affichez les combattants ici -->
        <li>Nom du combattant 1</li>
        <li>Nom du combattant 2</li>
        <!-- Répétez pour tous les combattants -->
    </ul>
</div>
</body>
</html>
