<?php
// admin-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php'; // Assurez-vous que ce fichier est correctement configuré et présent

// Fonctions pour les combattants
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        die("Catégorie non trouvée.");
    }
    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $stmt->close();
    return true;
}

function getAllCombattants($conn) {
    $query = "SELECT combattants_admin.*, categories.name as categorie_name FROM combattants_admin LEFT JOIN categories ON combattants_admin.categorie_id = categories.id";
    $result = $conn->query($query);
    $combattants = [];
    while ($row = $result->fetch_assoc()) {
        $combattants[] = $row;
    }
    return $combattants;
}

function getCombattant($conn, $id) {
    $query = "SELECT combattants_admin.*, categories.name as categorie_name FROM combattants_admin LEFT JOIN categories ON combattants_admin.categorie_id = categories.id WHERE combattants_admin.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows === 1 ? $result->fetch_assoc() : null;
}

function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        die("Catégorie non trouvée.");
    }
    $query = "UPDATE combattants_admin SET nom = ?, prenom = ?, surnom = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssii", $nom, $prenom, $surnom, $description, $image, $categorie_id, $id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $stmt->close();
    return true;
}

function deleteCombattant($conn, $id) {
    $query = "DELETE FROM combattants_admin WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $stmt->close();
    return true;
}

// Fonctions pour les catégories
function createCategorie($conn, $name) {
    $query = "INSERT INTO categories (name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $name);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $stmt->close();
    return true;
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

function deleteCategorie($conn, $id) {
    $query = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $stmt->close();
    return true;
}

// Fonctions pour les événements
function createEvenement($conn, $nom, $date, $lieu, $description) {
    $query = "INSERT INTO evenements_admin (nom, date, lieu, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nom, $date, $lieu, $description);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $stmt->close();
    return true;
}

function getAllEvenements($conn) {
    $query = "SELECT * FROM evenements_admin ORDER BY date ASC";
    $result = $conn->query($query);
    $evenements = [];
    while ($row = $result->fetch_assoc()) {
        $evenements[] = $row;
    }
    return $evenements;
}

function deleteEvenement($conn, $id) {
    $query = "DELETE FROM evenements_admin WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $stmt->close();
    return true;
}

function categorieExists($conn, $id) {
    $query = "SELECT id FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

?>
