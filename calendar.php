<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'common.php'; // Utiliser require pour inclure la configuration de la base de données

// Récupération des événements
function getEvents($conn) {
    $result = $conn->query("SELECT * FROM evenements_admin");
    if (!$result) {
        die("Erreur lors de la requête: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Connexion à la base de données et récupération des événements
try {
    $events = getEvents($conn);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Convertir les événements pour FullCalendar
$calendarEvents = array_map(function($event) {
    return [
        'title' => $event['nom'],
        'start' => $event['date'] . 'T' . $event['heure'],
        // Ajoutez d'autres propriétés ici si nécessaire
    ];
}, $events);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Calendrier des Événements</title>
    <link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet' />
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.css' rel='stylesheet' />
    <style>
        body {
            background-color: #333;
            color: white;
        }
        #calendar-container {
            max-width: 90%;
            margin: 20px auto;
            padding: 20px;
            background-color: #444;
            border-radius: 8px;
        }
        .fc-header-toolbar {
            color: white;
        }
        .fc-button {
            background-color: #555;
            color: white;
            border: none;
        }
        .fc-button:hover {
            background-color: #666;
        }
        .fc-daygrid-day-number {
            color: white;
        }
    </style>
</head>
<body>

<div id='calendar-container'>
    <div id='calendar'></div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: <?php echo json_encode($calendarEvents); ?>,
            // Ajoutez d'autres options ici si nécessaire
        });
        calendar.render();
    });
</script>

</body>
</html>