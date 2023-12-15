<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'common.php'; // Inclure la configuration de la base de données

// Récupération des événements
function getEvents($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM evenements_admin");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Connexion à la base de données et récupération des événements
try {
    // Assurez-vous que common.php initialise une variable $pdo pour la connexion PDO
    $events = getEvents($pdo);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Générer un calendrier pour le mois en cours
$month = date('m');
$year = date('Y');
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

echo '<div class="container mx-auto p-4">';
echo '<div class="grid grid-cols-7 gap-4">';

// Afficher les jours
for ($day = 1; $day <= $daysInMonth; $day++) {
    echo '<div class="border border-gray-200 p-2">';
    echo '<h3 class="text-lg font-semibold">' . $day . '</h3>';

    // Afficher les événements de ce jour
    foreach ($events as $event) {
        $eventDate = date('Y-m-d', strtotime($event['date']));
        if ($eventDate == $year . '-' . $month . '-' . str_pad($day, 2, '0', STR_PAD_LEFT)) {
            echo '<div class="mt-2 text-sm">';
            echo '<p>' . htmlspecialchars($event['nom']) . '</p>';
            echo '<p>' . htmlspecialchars($event['heure']) . '</p>';
            echo '</div>';
        }
    }

    echo '</div>';
}

echo '</div>';
echo '</div>';
?>
