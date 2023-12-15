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
            width: 70%;
            height: 85vh;
            margin: 20px auto;
            padding: 20px;
            background-color: #444;
            border-radius: 8px;
            overflow: hidden;
        }
        #calendar {
            height: 100%;
        }
        .fc .fc-col-header-cell-cushion,
        .fc .fc-daygrid-day-top,
        .fc .fc-daygrid-day-number {
            color: #FFF;
        }
        .fc .fc-daygrid-day {
            border: 1px solid #000; /* Lignes noires pour les cases du calendrier */
        }
        .fc-button-primary {
            background-color: #555;
            border: 1px solid #000;
            color: white;
        }
        .fc-button-primary:hover {
            background-color: #666;
        }
        #year-select {
            background-color: #555;
            color: white;
            border: 1px solid #000;
            padding: 5px;
            border-radius: 4px;
        }
        /* Autres styles ici */
    </style>
</head>
<body>

<div id='calendar-container'>
    <div id='calendar-controls' style="margin-bottom: 10px;">
        <label for="year-select">Année :</label>
        <select id="year-select">
            <?php for($i = 2020; $i <= 2030; $i++) { echo "<option value='$i'>$i</option>"; } ?>
        </select>
    </div>
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
            eventClick: function(info) {
                alert('Événement: ' + info.event.title + '\nDate: ' + info.event.start.toISOString());
                // Remplacer par une modal ou une autre interface
            }
        });

        calendar.render();

        // Gestion du changement d'année
        document.getElementById('year-select').addEventListener('change', function() {
            var year = this.value;
            var date = new Date(calendar.getDate());
            date.setFullYear(year);
            calendar.gotoDate(date); // Se déplace vers la nouvelle date
        });
    });
</script>

</body>
</html>
