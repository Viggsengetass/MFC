<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

// Vérifie si une session est déjà active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Inclure le fichier common.php pour la connexion à la base de données
include 'common.php';

// Connexion à la base de données
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if ($mysqli->connect_error) {
    die("Erreur de connexion à la base de données : " . $mysqli->connect_error);
}

// Fonction pour récupérer les informations de l'utilisateur connecté
function getLoggedInUserInfo($conn) {
    if (isset($_SESSION['user']) && isset($_SESSION['user']['username'])) {
        $username = $_SESSION['user']['username'];
        // Remplacez 'votre_table_utilisateurs' par le nom de votre table d'utilisateurs
        $sql = "SELECT * FROM votre_table_utilisateurs WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            return $result->fetch_assoc();
        }
    }
    return null;
}

// Récupérer les informations de l'utilisateur connecté
$loggedInUser = getLoggedInUserInfo($mysqli);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta charset="UTF-8" />
    <meta name="Description" content="entertainment and Art" />
    <title>Accueil - M.F.C MMA Tournament</title>
    <link rel="stylesheet" href="/style/header.css">
    <link rel="stylesheet" href="https://unpkg.com/feather-icons/dist/feather.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
<nav>
    <div class="menu">
        <input type="checkbox" id="check">
        <div class="logo"><a href="#"><img src="/img/logo.png" alt="MFC Logo" class="logo-img"></a></div>
        <ul>
            <label class="btn cancel" for="check"><i class="fas fa-times"></i></label>
            <li><a href="index.php" class="neumorphism_header">Accueil</a></li>
            <li><a href="combattants.php" class="neumorphism_header">Combattants</a></li>
            <li><a href="evenements.php" class="neumorphism_header">Événements</a></li>
            <li><a href="calendar.php" class="neumorphism_header">Calendrier</a></li>
            <li><a href="contact.php" class="neumorphism_header">Contact</a></li>
            <li><a href="admin-manage-combattants.php" class="neumorphism_header">Administration</a></li>


            <?php
            if ($loggedInUser) {
                echo '<li><span>Bienvenue, ' . htmlspecialchars($loggedInUser['username']) . '!</span></li>';
                echo '<li><a href="logout.php" class="neumorphism_header">Déconnexion</a></li>';
            } else {
                echo '<li><a href="login.php" class="neumorphism_header">Se Connecter</a></li>';
            }
            ?>
        </ul>
        <label for="check" class="btn bars"><i class="fas fa-bars"></i></label>
    </div>
</nav>
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
</body>

</html>
