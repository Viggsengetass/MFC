<?php
// Incluez le fichier de configuration de la base de données
include 'config.php';

// Vérifie si l'utilisateur est connecté en tant qu'administrateur
function isAdmin() {
    session_start();
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

// Fonction pour créer un nouveau combattant
function createCombattant($nom, $prenom, $surnom, $description, $image, $categorie_id, $conn) {
    // Vérifie le rôle de l'utilisateur
    if (!isAdmin()) {
        // Redirige ou effectue une autre action en cas d'accès non autorisé
        header('Location: unauthorized.php');
        exit();
    }

    // Effectuez des opérations pour insérer un nouveau combattant dans la base de données
    $query = "INSERT INTO combattants_admin (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    return $stmt->execute();
}

// Fonction pour créer un nouvel événement
function createEvent($nom, $date, $heure, $lieu, $description, $image, $categorie_id, $conn) {
    // Vérifie le rôle de l'utilisateur
    if (!isAdmin()) {
        // Redirige ou effectue une autre action en cas d'accès non autorisé
        header('Location: unauthorized.php');
        exit();
    }

    // Effectuez des opérations pour insérer un nouvel événement dans la base de données
    $query = "INSERT INTO evenements_admin (nom, date, heure, lieu, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $date, $heure, $lieu, $description, $image, $categorie_id);
    return $stmt->execute();
}

// Fonction pour obtenir tous les combattants
function getAllCombattants($conn) {
    // Vérifie le rôle de l'utilisateur
    if (!isAdmin()) {
        // Redirige ou effectue une autre action en cas d'accès non autorisé
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

// Fonction pour obtenir tous les événements
function getAllEvents($conn) {
    // Vérifie le rôle de l'utilisateur
    if (!isAdmin()) {
        // Redirige ou effectue une autre action en cas d'accès non autorisé
        header('Location: unauthorized.php');
        exit();
    }

    $query = "SELECT * FROM evenements_admin";
    $result = $conn->query($query);
    $events = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }
    return $events;
}

// Ajoutez d'autres fonctions pour gérer les opérations administratives spécifiques

?>
