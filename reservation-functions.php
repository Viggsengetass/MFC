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

// Récupération de la liste des événements
$evenements = getAllEvenements($conn);

// Récupération de l'identifiant de l'utilisateur depuis la session
$utilisateur_id = $_SESSION['user']['id'] ?? null; // Utilisez la même clé 'user' que dans d'autres parties de votre application

// Vérification de la connexion de l'utilisateur
if (!$utilisateur_id) {
    die("Vous devez être connecté pour faire une réservation.");
}

// Traitement du formulaire de réservation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $evenement_id = $_POST['evenement_id'];
    $nombre_billets = $_POST['nombre_billets'];
    $result = ajouterReservation($conn, $utilisateur_id, $evenement_id, $nombre_billets);
    if ($result === true) {
        // Envoyez l'e-mail de confirmation
        $evenement = getEvenement($conn, $evenement_id);

        if ($evenement) {
            $destinataire = $_SESSION['user']['email']; // Adresse e-mail de l'utilisateur connecté
            $sujet = "Confirmation de Réservation pour l'Événement " . htmlspecialchars($evenement['nom']);
            $message = "Vous avez réservé avec succès pour l'événement " . htmlspecialchars($evenement['nom']) . ".\n";
            $message .= "Date: " . htmlspecialchars($evenement['date']) . "\n";
            $message .= "Heure: " . htmlspecialchars($evenement['heure']) . "\n";
            $message .= "Lieu: " . htmlspecialchars($evenement['lieu']) . "\n";
            $message .= "Nombre de Billets: " . htmlspecialchars($nombre_billets) . "\n";

            if (mail($destinataire, $sujet, $message)) {
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
