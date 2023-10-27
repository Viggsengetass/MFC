<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: login.php'); // Redirige si l'utilisateur n'est pas connecté en tant qu'administrateur
    exit();
}

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action === 'create_combattant') {
        // Gérer la création d'un combattant
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $surnom = $_POST['surnom'];
        $description = $_POST['description'];

        // Gérez le téléchargement de l'image du combattant s'il est nécessaire
        if (!empty($_FILES['image']['name'])) {
            $image = "uploads/" . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        } else {
            $image = null; // Si aucune image n'est téléchargée
        }

        // Effectuez les opérations nécessaires pour insérer le combattant dans la base de données
        // Vous devrez ajouter les requêtes SQL ici pour insérer les données dans la table "combattants_admin"

        // Après la création réussie, redirigez ou effectuez d'autres actions
        header('Location: admin-manage-combattants.php');
    } elseif ($action === 'create_event') {
        // Gérer la création d'un événement
        $nom = $_POST['nom'];
        $date = $_POST['date'];
        $heure = $_POST['heure'];
        $lieu = $_POST['lieu'];
        $description = $_POST['description'];
        $categorie_id = $_POST['categorie_id'];

        // Gérez le téléchargement de l'image de l'événement s'il est nécessaire
        if (!empty($_FILES['image']['name'])) {
            $image = "uploads/" . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        } else {
            $image = null; // Si aucune image n'est téléchargée
        }

        // Effectuez les opérations nécessaires pour insérer l'événement dans la base de données
        // Vous devrez ajouter les requêtes SQL ici pour insérer les données dans la table "evenements_admin"

        // Après la création réussie, redirigez ou effectuez d'autres actions
        header('Location: admin-list-events.php');
    }
    // Ajoutez d'autres cas pour gérer d'autres actions d'administration
}
