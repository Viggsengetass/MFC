<?php
// admin-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php'; // Assurez-vous que ce fichier existe et est correct.

// Créer un combattant
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if ($conn instanceof mysqli === false) {
        die("La variable conn n'est pas une instance de mysqli.");
    }

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

// Obtenir tous les combattants
function getAllCombattants($conn) {
    $query = "SELECT * FROM combattants_admin";
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

// Obtenir un combattant spécifique par son ID
function getCombattant($conn, $id) {
    $query = "SELECT * FROM combattants_admin WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    } else {
        return null; // Aucun combattant trouvé avec cet ID
    }
}

// Mettre à jour les informations d'un combattant
function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    $query = "UPDATE combattants_admin SET nom = ?, prenom = ?, surnom = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("sssssii", $nom, $prenom, $surnom, $description, $image, $categorie_id, $id);
    if (!$stmt->execute()) {
        // Gérer l'erreur de contrainte de clé étrangère
        if ($conn->errno == 1452) {
            return "Contrainte de clé étrangère - Catégorie non valide.";
        }
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $stmt->close();
    return true;
}

// Supprimer un combattant de la base de données
function deleteCombattant($conn, $id) {
    $query = "DELETE FROM combattants_admin WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }
    $stmt->close();
    return true;
}

// Valider les données d'un combattant
function validateCombattant($nom, $prenom, $description, $image, $categorie_id) {
    // Ajoutez ici les validations supplémentaires si nécessaire
    return !empty($nom) && !empty($prenom) && !empty($description) && !empty($image) && is_numeric($categorie_id);
}

// Obtenir le nom d'une catégorie par son ID
function getCategoryName($id, $conn) {
    $query = "SELECT name FROM categories WHERE id = ?";
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

// Les autres fonctions existantes peuvent être ajoutées ici...

?>
