<?php
// admin-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php'; // Assurez-vous que ce chemin est correct

// Vérifie si la catégorie existe
function categorieExists($conn, $id) {
    $stmt = $conn->prepare("SELECT id FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Création d'un combattant
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        return "Catégorie non trouvée.";
    }
    $stmt = $conn->prepare("INSERT INTO combattants (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    $stmt->execute();
    return $stmt->insert_id;
}

// Obtenir tous les combattants
function getAllCombattants($conn) {
    // Vérifiez le nom de la colonne de la catégorie dans votre base de données et ajustez si nécessaire
    $query = "SELECT combattants_admin.*, categories.nom AS categorie_nom FROM combattants_admin LEFT JOIN categories ON combattants_admin.categorie_id = categories.id";
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

// Obtenir un combattant spécifique
function getCombattant($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM combattants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Mettre à jour un combattant
function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        return "Catégorie non trouvée.";
    }
    $stmt = $conn->prepare("UPDATE combattants SET nom = ?, prenom = ?, surnom = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?");
    $stmt->bind_param("sssssii", $nom, $prenom, $surnom, $description, $image, $categorie_id, $id);
    $stmt->execute();
    return $stmt->affected_rows;
}

// Supprimer un combattant
function deleteCombattant($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM combattants WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->affected_rows;
}

// Création d'une catégorie
function createCategorie($conn, $nom) {
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param("s", $nom);
    $stmt->execute();
    return $stmt->insert_id;
}

// Obtenir toutes les catégories
function getAllCategories($conn) {
    $result = $conn->query("SELECT * FROM categories");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Supprimer une catégorie
function deleteCategorie($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->affected_rows;
}

// Création d'un événement
function createEvenement($conn, $nom, $date, $lieu, $description) {
    $stmt = $conn->prepare("INSERT INTO evenements (nom, date, lieu, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nom, $date, $lieu, $description);
    $stmt->execute();
    return $stmt->insert_id;
}

// Obtenir tous les événements
function getAllEvenements($conn) {
    $result = $conn->query("SELECT * FROM evenements ORDER BY date ASC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Supprimer un événement
function deleteEvenement($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM evenements WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->affected_rows;
}

// Vous pouvez ajouter d'autres fonctions si nécessaire...

?>
