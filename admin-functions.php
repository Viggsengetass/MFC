<?php
// admin-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php'; // Assurez-vous que ce fichier existe et qu'il initialise $conn avec votre connexion mysqli.

// Assurez-vous que les noms des tables et des colonnes correspondent à ceux de votre base de données.

// Ajouter un nouveau combattant à la base de données
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        return "Catégorie non trouvée.";
    }
    $query = "INSERT INTO combattants (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    if (!$stmt->execute()) {
        return "Erreur lors de l'exécution de la requête: " . $stmt->error;
    }
    $stmt->close();
    return true;
}

// Récupérer tous les combattants de la base de données
function getAllCombattants($conn) {
    $query = "SELECT combattants.*, categories.name as categorie_name FROM combattants INNER JOIN categories ON combattants.categorie_id = categories.id";
    $combattants = [];
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $combattants[] = $row;
        }
    }
    return $combattants;
}

// Vérifier si une catégorie existe
function categorieExists($conn, $id) {
    $query = "SELECT id FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

// Récupérer le nom d'une catégorie
function getCategoryName($conn, $id) {
    $query = "SELECT name FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($name);
    $stmt->fetch();
    $stmt->close();
    return $name ?: false;
}

// Mettre à jour les informations d'un combattant
function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        return "Catégorie non trouvée.";
    }
    $query = "UPDATE combattants SET nom = ?, prenom = ?, surnom = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssii", $nom, $prenom, $surnom, $description, $image, $categorie_id, $id);
    if (!$stmt->execute()) {
        return "Erreur lors de l'exécution de la requête: " . $stmt->error;
    }
    $stmt->close();
    return true;
}

// Fonction pour supprimer un combattant
function deleteCombattant($conn, $id) {
    $query = "DELETE FROM combattants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

// Fonction pour obtenir un combattant spécifique
function getCombattant($conn, $id) {
    $query = "SELECT * FROM combattants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Ajouter un événement
// Assurez-vous que cette fonction est nécessaire ou mettez à jour la structure de la base de données en conséquence.
function createEvenement($conn, $nom, $date, $lieu, $description) {
    $query = "INSERT INTO evenements (nom, date, lieu, description) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nom, $date, $lieu, $description);
    if (!$stmt->execute()) {
        return "Erreur lors de l'exécution de la requête: " . $stmt->error;
    }
    $stmt->close();
    return true;
}

// Récupérer tous les événements
// Assurez-vous que cette fonction est nécessaire ou mettez à jour la structure de la base de données en conséquence.
function getAllEvenements($conn) {
    $query = "SELECT * FROM evenements ORDER BY date ASC";
    $evenements = [];
    if ($result = $conn->query($query)) {
        while ($row = $result->fetch_assoc()) {
            $evenements[] = $row;
        }
    }
    return $evenements;
}

?>
