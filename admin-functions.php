<?php
include 'config.php';

function isAdmin() {
    session_start();
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function createCombattant($nom, $prenom, $surnom, $description, $image, $categorie_id, $conn) {
    if (!isAdmin()) {
        header('Location: unauthorized.php');
        exit();
    }

    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function getAllCombattants($conn) {
    if (!isAdmin()) {
        header('Location: unauthorized.php');
        exit();
    }

    $query = "SELECT * FROM combattants_admin";
    $result = $conn->query($query);
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
?>
