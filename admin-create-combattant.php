<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Créer un combattant</title>
    <!-- Inclure ici vos liens CSS ou CDN -->
</head>

<body>
<h1>Créer un combattant</h1>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $surnom = $_POST['surnom'];
    $description = $_POST['description'];

    // Gérez le téléchargement de l'image du combattant s'il est nécessaire
    if (!empty($_FILES['image']['name'])) {
        $image = "uploads/" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    } else {
        $image = null; // Si aucune image n'est téléchargée
    }

    // Effectuez les opérations nécessaires pour insérer le combattant dans la base de données
    // Vous devrez ajouter les requêtes SQL ici pour insérer les données dans la table "combattants_admin"

    // Après la création réussie, redirigez ou effectuez d'autres actions
    header('Location: admin-manage-combattants.php');
}
?>

<form method="POST" enctype="multipart/form-data">
    <label for="nom">Nom:</label>
    <input type="text" name="nom" required><br>

    <label for="prenom">Prénom:</label>
    <input type="text" name="prenom" required><br>

    <label for="surnom">Surnom:</label>
    <input type="text" name="surnom"><br>

    <label for="description">Description:</label>
    <textarea name="description"></textarea><br>

    <label for="image">Image:</label>
    <input type="file" name="image"><br>

    <input type="submit" value="Créer le combattant">
</form>
</body>

</html>
