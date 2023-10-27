<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige si l'utilisateur n'est pas connecté en tant qu'administrateur
    exit();
}

include 'config.php';

function createCombattant($conn, $nom, $prenom, $surnom, $description, $image) {
    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssb", $nom, $prenom, $surnom, $description, $image);
        if ($stmt->execute()) {
            return true; // Création réussie
        }
    }

    return false; // Échec de la création
}

function createEvent($conn, $nom, $date, $heure, $lieu, $description, $image, $categorie_id) {
    $query = "INSERT INTO evenements_admin (nom, date, heure, lieu, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssssb", $nom, $date, $heure, $lieu, $description, $image, $categorie_id);
        if ($stmt->execute()) {
            return true; // Création réussie
        }
    }

    return false; // Échec de la création
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action === 'create_combattant') {
        // Gérer la création d'un combattant
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

        if (createCombattant($conn, $nom, $prenom, $surnom, $description, $image)) {
            header('Location: admin-manage-combattants.php');
        } else {
            // Gestion des erreurs
        }
    } elseif ($action === 'create_event') {
        // Gérer la création d'un événement
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $lieu = $_POST['lieu'];
        $description = $_POST['description'];
        $categorie_id = $_POST['categorie_id'];

        // Gérez le téléchargement de l'image de l'événement s'il est nécessaire
        if (!empty($_FILES['image']['name'])) {
            $image = "uploads/" . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        } else {
            $image = null; // Si aucune image n'est téléchargée
        }

        if (createEvent($conn, $nom, $date, $heure, $lieu, $description, $image, $categorie_id)) {
            header('Location: admin-list-events.php');
        } else {
            // Gestion des erreurs
        }
    }
    // Ajoutez d'autres cas pour gérer d'autres actions d'administration
}
?>
