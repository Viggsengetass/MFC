<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config.php'; // Inclure le fichier de configuration de la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Utilisez la fonction de traitement pour effectuer l'inscription
    $success = registerUser($username, $password, $email);

    if ($success) {
        // Rediriger vers la page de connexion après l'inscription réussie
        header('Location: login.php');
    } else {
        // Rediriger vers la page d'inscription avec un message d'erreur
        header('Location: register.php?error=1');
    }
}

// Fonction pour effectuer l'inscription d'un utilisateur
function registerUser($username, $password, $email) {
    global $conn;

    // Préparez la requête SQL avec des paramètres
    $query = "INSERT INTO users (nom, mot_de_passe, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        // La préparation de la requête a échoué
        return false;
    }

    // Liez les paramètres
    $bindResult = $stmt->bind_param("sss", $username, $password, $email);

    if (!$bindResult) {
        // La liaison des paramètres a échoué
        return false;
    }

    // Exécutez la requête
    $executeResult = $stmt->execute();

    if ($executeResult) {
        return true; // L'inscription a réussi
    } else {
        return false; // L'inscription a échoué
    }
}
