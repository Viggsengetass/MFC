<?php
include 'config.php';

function isAdmin() {
    session_start();
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function createCombattant($nom, $prenom, $surnom, $description, $image, $categorie_id, $conn) {
    if (!isAdmin()) {
        header('Location: unauthorized.php');
        exit();
    }

    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        // Gestion de l'erreur pour la requête préparée
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);

    if (!$stmt->execute()) {
        // Gestion de l'erreur pour l'exécution de la requête
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $stmt->close();
    return true;
}

function getAllCombattants($conn) {
    if (!isAdmin()) {
        header('Location: unauthorized.php');
        exit();
    }

    $query = "SELECT * FROM combattants_admin";
    $result = $conn->query($query);

    if (!$result) {
        // Gestion de l'erreur pour la requête
        die("Erreur lors de l'exécution de la requête: " . $conn->error);
    }

    $combattants = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $combattants[] = $row;
        }
    }

    return $combattants;
}

function validateCombatant($nom, $prenom, $description, $image, $categorie_id) {
    return !empty($nom) && !empty($prenom) && !empty($description) && !empty($image) && $categorie_id !== false;
}
?>
