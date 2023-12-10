<?php
// admin-functions.php

include 'config.php';

// Fonction pour récupérer le nom de la catégorie
function getCategoryName($category_id, $conn) {
    $query = "SELECT name FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("i", $category_id);

    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['name'];
    } else {
        return 'Inconnue';
    }
}

// Fonction pour créer un combattant
function createCombattant($nom, $prenom, $surnom, $description, $image, $categorie_id, $conn) {
    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);

    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $stmt->close();
    return true;
}

// Fonction pour récupérer tous les combattants
function getAllCombattants($conn) {
    $query = "SELECT * FROM combattants_admin";
    $result = $conn->query($query);

    if (!$result) {
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

// Fonction pour valider un combattant
function validateCombatant($nom, $prenom, $description, $image, $categorie_id) {
    return !empty($nom) && !empty($prenom) && !empty($description) && !empty($image) && $categorie_id !== false;
}
?>
