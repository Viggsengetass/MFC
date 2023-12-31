<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Si le formulaire de connexion est soumis
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Utilisez la fonction de traitement pour effectuer la connexion
        $result = loginUser($username, $password);

        if ($result['success']) {
            // Rediriger vers la page d'accueil après la connexion réussie
            header('Location: index.php');
        } else {
            // Rediriger vers la page de connexion avec un message d'erreur
            $_SESSION['login_error'] = "Nom d'utilisateur ou mot de passe incorrect.";
            header('Location: login.php');
        }
    } elseif (isset($_POST['register_username']) && isset($_POST['register_password']) && isset($_POST['register_email'])) {
        // Si le formulaire d'inscription est soumis
        $firstname = $_POST['firstname'];
        $register_username = $_POST['register_username'];
        $register_password = $_POST['register_password'];
        $register_email = $_POST['register_email'];
        $confirm_password = $_POST['confirm_password'];

        // Utilisez la fonction de traitement pour effectuer l'inscription
        $result = registerUser($register_username, $register_password, $register_email);

        if ($result['success']) {
            // Rediriger vers la page d'accueil après l'inscription réussie
            $_SESSION['registration_success'] = "Inscription réussie. Connectez-vous maintenant.";
            header('Location: login.php');
        } else {
            // Rediriger vers la page d'inscription avec un message d'erreur
            $_SESSION['registration_error'] = "Erreur lors de l'inscription. Veuillez réessayer.";
            header('Location: login.php');
        }
    }
}

// Fonction pour effectuer la connexion d'un utilisateur
function loginUser($username, $password) {
    global $conn;
    $result = array();

    // Requête SQL pour récupérer l'utilisateur en fonction du nom d'utilisateur
    $query = "SELECT * FROM users WHERE nom = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows == 1) {
        $user = $user_result->fetch_assoc();

        // Vérifiez si le mot de passe est correct
        if (password_verify($password, $user['mot_de_passe'])) {
            // Enregistrez l'utilisateur dans la session
            $_SESSION['user'] = $user;
            $result['success'] = true;
            $result['username'] = $user['nom'];
            return $result; // La connexion a réussi
        }
    }

    $result['success'] = false;
    return $result; // La connexion a échoué
}

// Fonction pour effectuer l'inscription d'un utilisateur
function registerUser($username, $password, $email) {
    global $conn;
    $result = array();

    // Hachez le mot de passe
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Préparez la requête SQL avec des paramètres
    $query = "INSERT INTO users (nom, mot_de_passe, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        // La préparation de la requête a échoué
        $result['success'] = false;
        return $result;
    }

    // Liez les paramètres
    $bindResult = $stmt->bind_param("sss", $username, $hashedPassword, $email);

    if (!$bindResult) {
        // La liaison des paramètres a échoué
        $result['success'] = false;
        return $result;
    }

    // Exécutez la requête
    $executeResult = $stmt->execute();

    if ($executeResult) {
        $result['success'] = true; // L'inscription a réussi
        return $result;
    } else {
        $result['success'] = false; // L'inscription a échoué
        return $result;
    }
}
?>
