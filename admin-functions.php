<?php
// admin-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php';

// Vérifie si une catégorie existe
function categorieExists($conn, $id) {
    $query = "SELECT id FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Fonctions pour les combattants
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        die("Catégorie non trouvée.");
    }
    $query = "INSERT INTO combattants (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    $stmt->execute();
    $stmt->close();
}

function getAllCombattants($conn) {
    // Assurez-vous que le nom de la colonne correspond à celui de votre base de données.
    $query = "SELECT combattants.*, categories.category_name AS categorie_name 
              FROM combattants 
              LEFT JOIN categories ON combattants.categorie_id = categories.id";
    $result = $conn->query($query);

    if (!$result) {
        die("Erreur lors de l'exécution de la requête: " . $conn->error);
    }

    $combattants = [];
    while ($row = $result->fetch_assoc()) {
        $combattants[] = $row;
    }
    return $combattants;
}


function getCombattant($conn, $id) {
    $query = "SELECT combattants.*, categories.name as categorie_name FROM combattants LEFT JOIN categories ON combattants.categorie_id = categories.id WHERE combattants.id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        die("Catégorie non trouvée.");
    }
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

// Fonctions pour les catégories
function createCategorie($conn, $name) {
    $query = "INSERT INTO categories (name) VALUES (?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $name);
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

function deleteCategorie($conn, $id) {
    $query = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
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
    $query = "SELECT * FROM evenements ORDER BY date ASC";
    $result = $conn->query($query);
    $evenements = [];
    while ($row = $result->fetch_assoc()) {
        $evenements[] = $row;
    }
    return $evenements;
}

function deleteEvenement($conn, $id) {
    $query = "DELETE FROM evenements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
