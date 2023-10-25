<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Utilisez la fonction de traitement pour vérifier la connexion
    $success = loginUser($username, $password);

    if ($success) {
        // Rediriger vers la page d'accueil (index.php) après la connexion réussie
        header('Location: index.php');
        exit; // Assurez-vous de quitter le script après la redirection
    } else {
        // Rediriger vers la page de connexion avec un message d'erreur
        header('Location: login.php?error=1');
    }
}

// Fonction pour vérifier la connexion d'un utilisateur
function loginUser($username, $password) {
    global $conn;

    // Recherchez l'utilisateur par nom d'utilisateur dans la base de données
    $query = "SELECT id, nom, mot_de_passe FROM users WHERE nom = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        // La préparation de la requête a échoué
        return false;
    }

    // Liez le paramètre
    $bindResult = $stmt->bind_param("s", $username);

    if (!$bindResult) {
        // La liaison des paramètres a échoué
        return false;
    }

    // Exécutez la requête
    $executeResult = $stmt->execute();

    if (!$executeResult) {
        // L'exécution de la requête a échoué
        return false;
    }

    // Récupérez le résultat de la requête
    $stmt->store_result();
    $stmt->bind_result($userId, $username, $hashedPassword);

    if ($stmt->num_rows == 1) {
        // L'utilisateur existe
        $stmt->fetch();

        // Vérifiez le mot de passe
        if (password_verify($password, $hashedPassword)) {
            // Le mot de passe est correct
            return true;
        }
    }

    return false; // La connexion a échoué
}
?>
