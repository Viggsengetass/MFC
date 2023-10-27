<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige si l'utilisateur n'est pas connecté en tant qu'administrateur
    exit();
}

include 'config.php';

// Fonction pour supprimer un événement
function deleteEvent($event_id, $conn) {
    $query = "DELETE FROM evenements WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    return $stmt->execute();
}

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    if (deleteEvent($event_id, $conn)) {
        header('Location: admin-list-events.php'); // Redirige après la suppression
        exit();
    } else {
        // Gérez le cas où la suppression a échoué
    }
}
?>
