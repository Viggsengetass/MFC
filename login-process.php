<?php
session_start();
include 'config.php'; // Inclure votre fichier de configuration de base de données

// Fonction pour la connexion de l'utilisateur
function loginUser($conn, $username, $password) {
    // Échapper les entrées utilisateur pour éviter les injections SQL
    $escapedUsername = mysqli_real_escape_string($conn, $username);
    $escapedPassword = mysqli_real_escape_string($conn, $password);

    // Requête SQL pour vérifier l'authentification
    $sql = "SELECT * FROM users WHERE username='$escapedUsername' AND password='$escapedPassword'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Vérifier si des données correspondantes ont été trouvées
        if (mysqli_num_rows($result) == 1) {
            // L'utilisateur est authentifié avec succès
            $user = mysqli_fetch_assoc($result);
            $_SESSION['user_id'] = $user['id'];
            return true;
        } else {
            // Échec de l'authentification
            return false;
        }
    } else {
        // Erreur de requête SQL
        return false;
    }
}

// Fonction pour l'enregistrement de l'utilisateur
function registerUser($conn, $username, $password, $email) {
    // Échapper les entrées utilisateur pour éviter les injections SQL
    $escapedUsername = mysqli_real_escape_string($conn, $username);
    $escapedPassword = mysqli_real_escape_string($conn, $password);
    $escapedEmail = mysqli_real_escape_string($conn, $email);

    // Vérifier si l'utilisateur existe déjà
    $checkExistingUser = "SELECT * FROM users WHERE username='$escapedUsername'";
    $existingUserResult = mysqli_query($conn, $checkExistingUser);

    if ($existingUserResult && mysqli_num_rows($existingUserResult) > 0) {
        // L'utilisateur existe déjà
        return false;
    } else {
        // Insérer le nouvel utilisateur dans la base de données
        $insertUser = "INSERT INTO users (username, password, email) VALUES ('$escapedUsername', '$escapedPassword', '$escapedEmail')";
        $insertResult = mysqli_query($conn, $insertUser);

        if ($insertResult) {
            // Enregistrement réussi
            return true;
        } else {
            // Erreur lors de l'enregistrement
            return false;
        }
    }
}

// Gérer la soumission du formulaire de connexion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login_submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Appeler la fonction de connexion
    if (loginUser($conn, $username, $password)) {
        // Connexion réussie, rediriger vers la page d'accueil
        header('Location: home.php');
        exit();
    } else {
        // Échec de la connexion, afficher un message d'erreur
        $_SESSION['login_error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
        header('Location: login.php');
        exit();
    }
}

// Gérer la soumission du formulaire d'enregistrement
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register_submit'])) {
    $registerUsername = $_POST['register_username'];
    $registerPassword = $_POST['register_password'];
    $registerEmail = $_POST['register_email'];

    // Appeler la fonction d'enregistrement
    if (registerUser($conn, $registerUsername, $registerPassword, $registerEmail)) {
        // Enregistrement réussi, rediriger vers la page de connexion
        $_SESSION['registration_success'] = 'Inscription réussie. Vous pouvez maintenant vous connecter.';
        header('Location: login.php');
        exit();
    } else {
        // Échec de l'enregistrement, afficher un message d'erreur
        $_SESSION['registration_error'] = 'L\'inscription a échoué. Veuillez réessayer.';
        header('Location: register.php');
        exit();
    }
}
?>
