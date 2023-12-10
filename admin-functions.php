<?php
// admin-functions.php

include 'config.php';

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

function validateCombatant($nom, $prenom, $description, $image, $categorie_id) {
    return !empty($nom) && !empty($prenom) && !empty($description) && !empty($image) && $categorie_id !== false;
}

function getCategoryName($id, $conn) {
    $query = "SELECT nom FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("i", $id);

    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();

    return $name;
}

function createEvenement($nom, $date, $lieu, $description, $conn) {
    $query = "INSERT INTO evenements_admin (nom, date, lieu, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("ssss", $nom, $date, $lieu, $description);

    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $stmt->close();
    return true;
}

function getAllEvenements($conn) {
    $query = "SELECT
        ea.id,
        ea.nom,
        ea.date,
        ea.heure,
        ea.lieu,
        ea.description,
        ea.image,
        ea.categorie_id,
        ea.combattant_id,
        ea.combattant2_id,
        c1.nom AS combattant1_nom,
        c2.nom AS combattant2_nom,
        c1.image AS image1,
        c2.image AS image2
    FROM
        evenements_admin ea
        JOIN combattants_admin c1 ON ea.combattant_id = c1.id
        JOIN combattants_admin c2 ON ea.combattant2_id = c2.id";

    $result = $conn->query($query);

    if (!$result) {
        die("Erreur lors de l'exécution de la requête: " . $conn->error);
    }

    $evenements = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $evenements[] = $row;
        }
    }

    return $evenements;
}
?>
