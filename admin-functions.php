<?php
include 'common.php'; // Assurez-vous que ce fichier contient les informations de connexion à la base de données

// Créer un nouveau combattant
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (empty($nom) || empty($prenom) || empty($description) || empty($image) || empty($categorie_id)) {
        return false; // Validation des champs
    }

    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }

    $stmt->close();
    return true;
}

// Récupérer tous les combattants
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

// Mettre à jour les informations d'un combattant
function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    $query = "UPDATE combattants_admin SET nom = ?, prenom = ?, surnom = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id, $id);
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }

    $stmt->close();
    return true;
}

// Supprimer un combattant
function deleteCombattant($conn, $id) {
    $query = "DELETE FROM combattants_admin WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        $stmt->close();
        return false;
    }

    $stmt->close();
    return true;
}

// Récupérer les détails d'un combattant spécifique
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
?>
