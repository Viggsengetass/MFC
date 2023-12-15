<?php
// reservation-functions.php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'common.php'; // Utiliser require_once pour être sûr que le fichier est inclus une seule fois

function ajouterReservation($conn, $utilisateur_id, $evenement_id, $nombre_billets) {
    $query = "INSERT INTO reservations (utilisateur_id, evenement_id, nombre_billets) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return "Erreur de préparation de la requête: " . $conn->error;
    }

    $stmt->bind_param("iii", $utilisateur_id, $evenement_id, $nombre_billets);
    if (!$stmt->execute()) {
        return "Erreur lors de l'exécution de la requête: " . $stmt->error;
    }

    $stmt->close();
    return true;
}

function getReservationsUtilisateur($conn, $utilisateur_id) {
    $query = "SELECT r.id, e.nom, r.nombre_billets FROM reservations r JOIN evenements e ON r.evenement_id = e.id WHERE r.utilisateur_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $utilisateur_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
    $stmt->close();
    return $reservations;
}

function getEvenementDetails($conn, $evenement_id) {
    $query = "SELECT * FROM evenements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $evenement_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
?>
