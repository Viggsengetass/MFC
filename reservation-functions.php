<?php
// Configuration pour afficher les erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session (déplacer cette ligne en haut)
session_start();

// Inclusion des fichiers nécessaires
require_once 'common.php';
require_once 'reservation-functions.php';
require_once 'admin-functions.php';

// Fonction pour envoyer un e-mail de confirmation
function sendConfirmationEmail($destinataire, $evenement, $nombre_billets) {
    $sujet = "Confirmation de Réservation pour l'Événement " . htmlspecialchars($evenement['nom']);
    $message = "Vous avez réservé avec succès pour l'événement " . htmlspecialchars($evenement['nom']) . ".\n";
    $message .= "Date: " . htmlspecialchars($evenement['date']) . "\n";
    $message .= "Heure: " . htmlspecialchars($evenement['heure']) . "\n";
    $message .= "Lieu: " . htmlspecialchars($evenement['lieu']) . "\n";
    $message .= "Nombre de Billets: " . htmlspecialchars($nombre_billets) . "\n";

    return mail($destinataire, $sujet, $message);
}

// Vérification de la connexion de l'utilisateur
if (!isset($_SESSION['user']['id'])) {
    die("Vous devez être connecté pour faire une réservation.");
}

// Traitement du formulaire de réservation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $evenement_id = $_POST['evenement_id'];
    $nombre_billets = $_POST['nombre_billets'];
    $result = ajouterReservation($conn, $_SESSION['user']['id'], $evenement_id, $nombre_billets);
    if ($result === true) {
        // Récupération des informations sur l'événement
        $evenement = getEvenement($conn, $evenement_id);

        if ($evenement) {
            // Envoyer l'e-mail de confirmation
            $destinataire = $_SESSION['user']['email']; // Adresse e-mail de l'utilisateur connecté
            if (sendConfirmationEmail($destinataire, $evenement, $nombre_billets)) {
                // Redirigez l'utilisateur vers une page de confirmation de réservation
                header('Location: confirmation.php');
                exit();
            } else {
                // Gestion de l'erreur d'envoi de l'e-mail
                echo "L'envoi de l'e-mail de confirmation a échoué.";
            }
        } else {
            echo "Événement non trouvé.";
        }
    } else {
        // Afficher un message d'erreur si la réservation échoue
        $erreur_message = "Erreur lors de la réservation : " . $result;
    }
}
?>
