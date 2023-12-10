<?php
// Démarrage de la session PHP
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Balises meta pour définir la vue, l'encodage, la compatibilité, et la description -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta charset="utf-8" />
    <meta name="Description" content="entertainment and Art" />
    <!-- Titre de la page -->
    <title>Accueil - M.F.C MMA Tournament</title>
    <!-- Liens vers les feuilles de style -->
    <link rel="stylesheet" href="/style/header.css">
    <link rel="stylesheet" href="https://unpkg.com/feather-icons/dist/feather.min.css">
    <!-- Script pour charger les icônes de Font Awesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</head>

<body>
<!-- Barre de navigation -->
<nav>
    <!-- Conteneur du menu -->
    <div class="menu">
        <!-- Input checkbox pour le menu déroulant sur les petits écrans -->
        <input type="checkbox" id="check">
        <!-- Logo du site -->
        <div class="logo"><a href="#"><img src="/img/logo.png" alt="MFC Logo" class="logo-img"></a></div>
        <!-- Liste des liens de navigation -->
        <ul>
            <!-- Label pour fermer le menu déroulant -->
            <label class="btn cancel" for="check"><i class="fas fa-times"></i></label>
            <!-- Liens vers les différentes pages du site -->
            <li><a href="index.php">Accueil</a></li>
            <li><a href="combattants.php">Combattants</a></li>
            <li><a href="evenements.php">Événements</a></li>
            <li><a href="contact.php">Contact</a></li>
            <!-- Vérification de la session utilisateur pour afficher le nom d'utilisateur ou le lien de connexion/déconnexion -->
            <?php
            if (isset($_SESSION['user'])) {
                echo '<li>Bienvenue, ' . $_SESSION['user']['username'] . '!</li>';
                echo '<li><a href="logout.php">Déconnexion</a></li>';
            } else {
                echo '<li><a href="login.php">Se Connecter</a></li>';
            }
            ?>
        </ul>
        <!-- Bouton de menu pour les petits écrans -->
        <label for="check" class="btn bars"><i class="fas fa-bars"></i></label>
    </div>
</nav>

<!-- Script pour remplacer les icônes Feather -->
<script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace();
</script>
</body>

</html>
