<?php
// admin-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php'; // Utiliser require_once pour être sûr que le fichier est inclus une seule fois

function categorieExists($conn, $id) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    return $row[0] > 0;
}

// Créez un nouveau combattant dans la base de données
function createCombattant($conn, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    if (!categorieExists($conn, $categorie_id)) {
        return "Catégorie non trouvée.";
    }
    $stmt = $conn->prepare("INSERT INTO combattants_admin (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    if (!$stmt->execute()) {
        return $stmt->error;
    }
    $stmt->close();
    return true;
}

// Récupérez tous les combattants de la base de données
function getAllCombattants($conn) {
    $result = $conn->query("SELECT * FROM combattants_admin");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function validateCombatant($nom, $prenom, $description, $image, $categorie_id) {
    return !empty($nom) && !empty($prenom) && !empty($description) && !empty($image) && $categorie_id !== false;
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

// Delete a combatant from the database
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

// Function to retrieve a single combatant's details
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
        return null; // No combatant found with this ID
    }
}

function updateCombattant($conn, $id, $nom, $prenom, $surnom, $description, $image, $categorie_id) {
    // Check if the category exists before attempting to update
    if (!categorieExists($conn, $categorie_id)) {
        return "Catégorie non trouvée."; // Return error message instead of dying
    }

    $query = "UPDATE combattants_admin SET nom = ?, prenom = ?, surnom = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        die("Erreur de préparation de la requête: " . $conn->error);
    }

    $stmt->bind_param("sssssii", $nom, $prenom, $surnom, $description, $image, $categorie_id, $id);
    if (!$stmt->execute()) {
        die("Erreur lors de l'exécution de la requête: " . $stmt->error);
    }

    $stmt->close();
    return true; // Return true on success
}

?>
