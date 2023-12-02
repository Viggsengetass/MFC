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

function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
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

        if (createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id)) {
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
