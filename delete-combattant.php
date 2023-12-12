// delete-combattant.php
<?php
//session_start();
require_once 'admin-functions.php';
require_once 'config.php';

//checkAdmin();

// Récupérez l'ID du combattant à supprimer
$combattantId = $_GET['id'] ?? null;

if ($combattantId) {
deleteCombattant($conn, $combattantId);
header('Location: admin-manage-combattants.php');
exit();
} else {
// Gérer l'erreur si l'ID n'est pas fourni
echo "Erreur : Aucun ID de combattant fourni.";
}
