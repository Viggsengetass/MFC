<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'common.php'; // Utiliser require pour inclure la configuration de la base de données

function getEvents($conn) {
    $result = $conn->query("SELECT * FROM evenements_admin");
    if (!$result) {
        die("Erreur lors de la requête: " . $conn->error);
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

try {
    $events = getEvents($conn);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

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
            box-shadow: 8px 8px 15px #2a2a2a, -8px -8px 15px #404040;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }
        .modal-content {
            background-color: #444;
            margin: 15% auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            width: 40%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        .reserve {
            background-color: #555;
            color: white;
            padding: 12px 24px;
            margin: 15px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .reserve:hover {
            background-color: #666;
        }
    </style>
</head>
<body>

<div id='calendar-container'>
    <div id='calendar'></div>
</div>

<div id="eventModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="eventTitle"></h2>
        <p id="eventDetails"></p>
        <a href="#" id="eventLink" class="reserve">Réserver</a>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.9.0/main.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: <?php echo json_encode($calendarEvents); ?>,
            eventClick: function(info) {
                document.getElementById('eventTitle').textContent = info.event.title;
                document.getElementById('eventDetails').textContent = 'Date: ' + info.event.start.toISOString();
                document.getElementById('eventLink').href = 'reservation_link'; // Remplacer par le lien de réservation réel
                document.getElementById('eventModal').style.display = 'block';
            }
        });

        calendar.render();

        var closeButton = document.getElementsByClassName('close')[0];
        closeButton.onclick = function() {
            document.getElementById('eventModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('eventModal')) {
                document.getElementById('eventModal').style.display = 'none';
            }
        }
    });
</script>

</body>
</html>
