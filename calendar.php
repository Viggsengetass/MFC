<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'common.php';

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
        'id' => $event['id'],
        'title' => $event['nom'],
        'start' => $event['date'] . 'T' . $event['heure'],
        'extendedProps' => [
            'description' => $event['description'],
            'lieu' => $event['lieu']
        ]
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
        #calendar {
            height: 100%;
        }
        .fc .fc-col-header-cell-cushion,
        .fc .fc-daygrid-day-top,
        .fc .fc-daygrid-day-number {
            color: #FFF;
        }
        .fc .fc-daygrid-day {
            border: none;
            box-shadow: inset 5px 5px 10px #2a2a2a, inset -5px -5px 10px #404040;
        }
        .fc-button-primary {
            background-color: #555;
            border: 1px solid #000;
            color: white;
            box-shadow: 2px 2px 5px #2a2a2a, -2px -2px 5px #404040;
        }
        .fc-button-primary:hover {
            background-color: #666;
        }
        #year-select, #month-select {
            background-color: #555;
            color: white;
            border: none;
            padding: 5px;
            border-radius: 4px;
            margin-right: 5px;
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
    <div id='calendar-controls' style="margin-bottom: 10px;">
        <label for="year-select">Année :</label>
        <select id="year-select">
            <?php for ($i = 2020; $i <= 2030; $i++) { echo "<option value='$i'".($i === (int)date('Y') ? ' selected' : '').">$i</option>"; } ?>
        </select>
        <label for="month-select">Mois :</label>
        <select id="month-select">
            <?php
            $mois = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
            foreach ($mois as $index => $nom) {
                echo "<option value='" . ($index + 1) . "'" .($index === (int)date('n') - 1 ? ' selected' : ''). ">$nom</option>";
            }
            ?>
        </select>
    </div>
    <div id='calendar'></div>
</div>

<div id="eventModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 id="modalTitle"></h2>
        <p id="modalDate"></p>
        <p id="modalBody"></p>
        <button id="modalReserveButton" class="reserve">Réserver</button>
    </div>
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
                var eventObj = info.event;
                document.getElementById('modalTitle').textContent = eventObj.title;
                document.getElementById('modalDate').textContent = 'Date: ' + new Date(eventObj.start).toLocaleString();
                document.getElementById('modalBody').textContent = eventObj.extendedProps.description;
                document.getElementById('modalReserveButton').onclick = function() {
                    window.location.href = 'reservation.php?event_id=' + eventObj.id;
                };
                document.getElementById('eventModal').style.display = 'block';
            }
        });

        calendar.render();

        document.getElementById('year-select').addEventListener('change', function() {
            var year = this.value;
            var date = new Date(calendar.getDate());
            date.setFullYear(year);
            calendar.gotoDate(date);
        });

        document.getElementById('month-select').addEventListener('change', function() {
            var month = this.value - 1;
            var date = new Date(calendar.getDate());
            date.setMonth(month);
            calendar.gotoDate(date);
        });

        var closeModal = document.getElementsByClassName('close')[0];
        closeModal.onclick = function() {
            document.getElementById('eventModal').style.display = 'none';
        };

        window.onclick = function(event) {
            if (event.target == document.getElementById('eventModal')) {
                document.getElementById('eventModal').style.display = 'none';
            }
        };
    });
</script>

</body>
</html>
