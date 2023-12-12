<?php
// Assurez-vous que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté et est administrateur
// Cette vérification est désactivée pour le développement

// Voici la barre latérale avec les liens
?>

<div id="sidebar">
    <ul>
        <li><a href="admin-dashboard.php">Tableau de Bord</a></li>
        <li><a href="admin-manage-combattants.php">Gérer les Combattants</a></li>
        <li><a href="admin-create-event.php">Créer un Événement</a></li>
        <li><a href="admin-list-events.php">Liste des Événements</a></li>
        <li><a href="logout.php">Déconnexion</a></li>
    </ul>
</div>
