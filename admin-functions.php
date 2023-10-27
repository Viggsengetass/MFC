<?php
// Incluez le fichier de configuration de la base de données
include 'config.php';

// Fonction pour créer un nouveau combattant
function createCombattant($nom, $prenom, $surnom, $description, $image, $categorie_id, $conn) {
    // Effectuez des opérations pour insérer un nouveau combattant dans la base de données
    $query = "INSERT INTO combattants (nom, prenom, surnom, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id);
    return $stmt->execute();
}

// Fonction pour créer un nouvel événement
function createEvent($nom, $date, $heure, $lieu, $description, $image, $categorie_id, $conn) {
    // Effectuez des opérations pour insérer un nouvel événement dans la base de données
    $query = "INSERT INTO evenements (nom, date, heure, lieu, description, image, categorie_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $date, $heure, $lieu, $description, $image, $categorie_id);
    return $stmt->execute();
}

// Fonction pour obtenir tous les combattants
function getAllCombattants($conn) {
    $query = "SELECT * FROM combattants";
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
    $query = "SELECT * FROM evenements";
    $result = $conn->query($query);
    $events = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }
    return $events;
}

// Fonction pour obtenir les détails d'un combattant par son ID
function getCombattantDetails($combattant_id, $conn) {
    $query = "SELECT * FROM combattants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $combattant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fonction pour obtenir les détails d'un événement par son ID
function getEventDetails($event_id, $conn) {
    $query = "SELECT * FROM evenements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fonction pour mettre à jour les détails d'un combattant
function updateCombattant($combattant_id, $nom, $prenom, $surnom, $description, $image, $categorie_id, $conn) {
    $query = "UPDATE combattants SET nom = ?, prenom = ?, surnom = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $prenom, $surnom, $description, $image, $categorie_id, $combattant_id);
    return $stmt->execute();
}

// Fonction pour mettre à jour les détails d'un événement
function updateEvent($event_id, $nom, $date, $heure, $lieu, $description, $image, $categorie_id, $conn) {
    $query = "UPDATE evenements SET nom = ?, date = ?, heure = ?, lieu = ?, description = ?, image = ?, categorie_id = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nom, $date, $heure, $lieu, $description, $image, $categorie_id, $event_id);
    return $stmt->execute();
}

// Fonction pour supprimer un combattant
function deleteCombattant($combattant_id, $conn) {
    $query = "DELETE FROM combattants WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $combattant_id);
    return $stmt->execute();
}

// Fonction pour supprimer un événement
function deleteEvent($event_id, $conn) {
    $query = "DELETE FROM evenements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    return $stmt->execute();
}

// Ajoutez d'autres fonctions pour gérer les opérations administratives spécifiques

?>
