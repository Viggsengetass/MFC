<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Utilisez la fonction de traitement pour vérifier la connexion
    $user = loginUser($username, $password);

    if ($user) {
        if ($user['role'] === 'admin') {
            // L'utilisateur est un administrateur, redirigez-le vers le tableau de bord administrateur
            header('Location: admin-dashboard.php');
            exit; // Assurez-vous de quitter le script après la redirection
        } else {
            // L'utilisateur est un utilisateur normal, redirigez-le vers la page d'accueil (index.php) ou toute autre page appropriée
            header('Location: index.php');
            exit; // Assurez-vous de quitter le script après la redirection
        }
    } else {
        // La connexion a échoué, stockez un message d'erreur dans une variable de session
        session_start();
        $_SESSION['login_error'] = "Nom d'utilisateur ou mot de passe incorrect";

        // Redirigez vers la page de connexion
        header('Location: login.php');
        exit; // Assurez-vous de quitter le script après la redirection
    }
}

// Fonction pour vérifier la connexion d'un utilisateur
function loginUser($username, $password) {
    global $conn;

    // Recherchez l'utilisateur par nom d'utilisateur dans la base de données
    $query = "SELECT id, nom, mot_de_passe, role FROM users WHERE nom = ?";
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
    $stmt->bind_result($userId, $username, $hashedPassword, $role);

    if ($stmt->num_rows == 1) {
        // L'utilisateur existe
        $stmt->fetch();

        // Vérifiez le mot de passe
        if (password_verify($password, $hashedPassword)) {
            // Le mot de passe est correct
            return [
                'id' => $userId,
                'username' => $username,
                'role' => $role
            ];
        }
    }

    return false; // La connexion a échoué
}
?>
