<?php

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'mfc');
define('DB_PASSWORD', 'monstre-f-club');
define('DB_NAME', 'mfc');

$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

//if (!$conn) {
//    die("ERREUR : Impossible de se connecter à la base de données. " . mysqli_connect_error());
//}
// elseif ($conn) {
//    echo "Connexion réussie";
//} else {
//    echo "jsp moi";
//}
?>