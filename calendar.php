<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Inclure le fichier common.php pour la connexion à la base de données
include 'common.php';

// Sélectionnez les événements depuis la table evenements_admin
$sql = "SELECT id, nom, date, heure FROM evenements_admin";
$result = $mysqli->query($sql);

// Créez un tableau pour stocker les événements au format JSON
$events = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $event = array(
            'id' => $row['id'],
            'title' => $row['nom'],
            'start' => $row['date'] . 'T' . $row['heure'], // Format date et heure ISO
        );
        array_push($events, $event);
    }
}

// Convertissez le tableau d'événements en format JSON
$events = json_encode($events);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier d'événements</title>
    <!-- Inclure FullCalendar depuis CDN -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.0/main.min.js"></script>
</head>
<body>
<div id="calendar"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            // Options de configuration ici
            initialView: 'dayGridMonth', // Vue initiale (mois)
            events: <?php echo $events; ?>, // Utilisation du tableau JSON des événements
        });

        calendar.render(); // Afficher le calendrier
    });
</script>
</body>
</html>
