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

// Inclusion de la bibliothèque PHPMailer (assurez-vous qu'elle est correctement installée)
require_once 'PHPMailer/PHPMailer.php';
require_once 'PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// Récupération de la liste des événements
$evenements = getAllEvenements($conn);

// Récupération de l'identifiant de l'utilisateur depuis la session
$utilisateur_id = $_SESSION['user']['id'] ?? null; // Utilisez la même clé 'user' que dans d'autres parties de votre application

// Vérification de la connexion de l'utilisateur
if (!$utilisateur_id) {
    die("Vous devez être connecté pour faire une réservation.");
}

// Fonction pour envoyer un e-mail de confirmation
function envoyerEmailConfirmation($evenementNom, $nombreBillets, $adresseEmail)
{
    // Création de l'objet PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP (vous devrez le configurer correctement)
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Remplacez par votre serveur SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'your_username'; // Remplacez par votre nom d'utilisateur SMTP
        $mail->Password = 'your_password'; // Remplacez par votre mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Utilisez STARTTLS
        $mail->Port = 587;

        // Configuration de l'émetteur et du destinataire
        $mail->setFrom('paulito.antoine@gmail.com', 'Paul ANTOINE');
        $mail->addAddress($adresseEmail);

        // Sujet et corps du message
        $mail->isHTML(true);
        $mail->Subject = 'Confirmation de réservation';
        $mail->Body = "Vous avez réservé $nombreBillets billet(s) pour l'événement : $evenementNom.";

        // Envoi de l'e-mail
        $mail->send();

        return true;
    } catch (Exception $e) {
        return "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}

// Traitement du formulaire de réservation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $evenement_id = $_POST['evenement_id'];
    $nombre_billets = $_POST['nombre_billets'];
    $result = ajouterReservation($conn, $utilisateur_id, $evenement_id, $nombre_billets);

    if ($result === true) {
        // Récupération du nom de l'événement pour l'e-mail de confirmation
        $evenement = getEvenementById($conn, $evenement_id);
        $evenementNom = $evenement['nom'];

        // Envoi de l'e-mail de confirmation
        $adresseEmail = $_SESSION['user']['email']; // Adresse e-mail de l'utilisateur connecté
        $emailResult = envoyerEmailConfirmation($evenementNom, $nombre_billets, $adresseEmail);

        if ($emailResult === true) {
            // Redirection vers le panier avec un message de succès
            $_SESSION['message'] = "Réservation ajoutée avec succès au panier. Un e-mail de confirmation a été envoyé.";
            header('Location: panier.php');
            exit();
        } else {
            // Afficher un message d'erreur si l'envoi de l'e-mail échoue
            $erreur_message = "Erreur lors de la réservation : $result. Erreur d'envoi d'e-mail : $emailResult";
        }
    } else {
        // Afficher un message d'erreur si la réservation échoue
        $erreur_message = "Erreur lors de la réservation : $result";
    }
}
?>
