<?php
// admin-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php'; // Assurez-vous que ce fichier existe et est correctement configuré

// Fonctions pour les combattants
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    $query = "INSERT INTO combattants (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    $stmt->execute();
    $stmt->close();
}

function getAllCombattants($conn) {
    $query = "SELECT * FROM combattants";
    $result = $conn->query($query);
    $combattants = [];
    while ($row = $result->fetch_assoc()) {
        $combattants[] = $row;
    }
    return $combattants;
}

function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    $query = "UPDATE combattants SET nom = ?, prenom = ?, surnom = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssii", $nom, $prenom, $surnom, $description, $image, $categorie_id, $id);
    $stmt->execute();
    $stmt->close();
}

function deleteCombattant($conn, $id) {
    $query = "DELETE FROM combattants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function getCombattant($conn, $id) {
    $query = "SELECT * FROM combattants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fonctions pour les événements
function createEvenement($conn, $nom, $date, $lieu, $description) {
    $query = "INSERT INTO evenements (nom, date, lieu, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nom, $date, $lieu, $description);
    $stmt->execute();
    $stmt->close();
}

function getAllEvenements($conn) {
    $query = "SELECT * FROM evenements";
    $result = $conn->query($query);
    $evenements = [];
    while ($row = $result->fetch_assoc()) {
        $evenements[] = $row;
    }
    return $evenements;
}

function updateEvenement($conn, $id, $nom, $date, $lieu, $description) {
    $query = "UPDATE evenements SET nom = ?, date = ?, lieu = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssi", $nom, $date, $lieu, $description, $id);
    $stmt->execute();
    $stmt->close();
}

function deleteEvenement($conn, $id) {
    $query = "DELETE FROM evenements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function getEvenement($conn, $id) {
    $query = "SELECT * FROM evenements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fonctions pour les catégories
function createCategorie($conn, $nom) {
    $query = "INSERT INTO categories (nom) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nom);
    $stmt->execute();
    $stmt->close();
}

function getAllCategories($conn) {
    $query = "SELECT * FROM categories";
    $result = $conn->query($query);
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    return $categories;
}

function updateCategorie($conn, $id, $nom) {
    $query = "UPDATE categories SET nom = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nom, $id);
    $stmt->execute();
    $stmt->close();
}

function deleteCategorie($conn, $id) {
    $query = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function getCategorie($conn, $id) {
    $query = "SELECT * FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

?>
