<?php
// admin-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php'; // Utiliser require_once pour être sûr que le fichier est inclus une seule fois

function createCombattant($conn, $nom, $prenom, $surnom, $description, $image_combattant1, $image_combattant2, $categorie_id) {
    // Assurez-vous que la connexion est une instance mysqli valide
    if ($conn instanceof mysqli === false) {
        return "La variable de connexion n'est pas une instance de mysqli.";
    }

    // Vérifiez si la catégorie existe
    if (!categorieExists($conn, $categorie_id)) {
        return "Catégorie non trouvée.";
    }

    // Préparez l'instruction d'insertion
    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image_combattant1, image_combattant2, categorie_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return "Erreur de préparation de la requête: " . $conn->error;
    }

    // Liez les paramètres et exécutez l'instruction
    $stmt->bind_param("ssssssi", $nom, $prenom, $surnom, $description, $image_combattant1, $image_combattant2, $categorie_id);
    if (!$stmt->execute()) {
        return "Erreur lors de l'exécution de la requête: " . $stmt->error;
    }

    // Fermez l'instruction
    $stmt->close();
    return true; // Renvoie true pour indiquer le succès
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

function validateCombatant($nom, $prenom, $description, $image_combattant1, $image_combattant2, $categorie_id) {
    return !empty($nom) && !empty($prenom) && !empty($description) && !empty($image_combattant1) && !empty($image_combattant2) && $categorie_id !== false;
}

function categorieExists($conn, $id) {
    $query = "SELECT id FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

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

function createEvenement($conn, $nom, $date, $heure, $lieu, $description, $combattant1_id, $combattant2_id, $image_combattant1, $image_combattant2) {
    $query = "INSERT INTO evenements_admin (nom, date, heure, lieu, description, combattant1_id, combattant2_id, image_combattant1, image_combattant2) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("sssssiiss", $nom, $date, $heure, $lieu, $description, $combattant1_id, $combattant2_id, $image_combattant1, $image_combattant2);

    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $stmt->close();
    return true;
}

function getAllEvenements($conn) {
    $query = "SELECT * FROM evenements_admin ORDER BY date ASC";
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

// Fonction pour récupérer les détails d'un combattant unique
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

function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image_combattant1, $image_combattant2, $categorie_id) {
    // Vérifiez si la catégorie existe avant de tenter de mettre à jour
    if (!categorieExists($conn, $categorie_id)) {
        return "Catégorie non trouvée."; // Renvoyer un message d'erreur au lieu de mourir
    }

    $query = "UPDATE combattants_admin SET nom = ?, prenom = ?, surnom = ?, description = ?, image_combattant1 = ?, image_combattant2 = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("ssssssii", $nom, $prenom, $surnom, $description, $image_combattant1, $image_combattant2, $categorie_id, $id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $stmt->close();
    return true; // Renvoyer true en cas de succès
}

function getAllCategories($conn) {
    $query = "SELECT * FROM categories";
    $result = $conn->query($query);

    if (!$result) {
        die("Erreur lors de l'exécution de la requête: " . $conn->error);
    }

    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    return $categories;
}
?>
