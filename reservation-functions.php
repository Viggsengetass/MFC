<?php
// Configuration pour afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session
session_start();

// Inclusion des fichiers nécessaires
require_once 'common.php';
require_once 'reservation-functions.php';

// Récupération de l'identifiant de l'utilisateur depuis la session
$utilisateur_id = $_SESSION['user']['id'] ?? null; // Utilisez la même clé 'user' que dans d'autres parties de votre application

// Vérification de la connexion de l'utilisateur
if (!$utilisateur_id) {
    die("Vous devez être connecté pour faire une réservation.");
}

// Récupération des informations du formulaire
$evenement_id = $_POST['evenement_id'] ?? 0;
$nombre_billets = $_POST['nombre_billets'] ?? 0;

// Récupération des informations de l'événement sélectionné
$evenement = getEvenementDetails($conn, $evenement_id);

// Vérification si l'événement existe
if (!$evenement) {
    $erreur_message = "Erreur! Événement non trouvé."; // Message d'erreur personnalisé
}

// Traitement du formulaire de réservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$erreur_message) {
    // Vérifiez si l'utilisateur a sélectionné un événement valide
    if ($evenement_id && $nombre_billets > 0) {
        $result = ajouterReservation($conn, $utilisateur_id, $evenement_id, $nombre_billets);
        if ($result === true) {
            // Redirection vers le panier avec un message de succès
            $_SESSION['message'] = "Réservation ajoutée avec succès au panier.";
            header('Location: panier.php');
            exit();
        } else {
            // Afficher un message d'erreur si la réservation échoue
            $erreur_message = "Erreur lors de la réservation : " . $result;
        }
    } else {
        // Afficher un message d'erreur si les données du formulaire ne sont pas valides
        $erreur_message = "Veuillez sélectionner un événement et spécifier le nombre de billets à réserver.";
    }
}
?>
