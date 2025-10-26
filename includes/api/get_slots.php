<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
header('Content-Type: application/json');

$date = $_GET['date'] ?? date('Y-m-d');

// definisikan jam kerja
$working_hours = ['08:00', '09:00', '10:00', '11:00', '12:00', '13:00'];

try {
    $stmt = db()->prepare("SELECT preferred_time FROM appointments WHERE preferred_date = ? AND status != 'cancelled'");
    $stmt->execute([$date]);
    $booked = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $slots = [];
    foreach ($working_hours as $time) {
        // MySQL simpan TIME dengan :00 di akhir
        $isAvailable = !in_array($time.':00', $booked);
        $slots[] = [
            'time' => $time,
            'available' => $isAvailable,
        ];
    }

    echo json_encode($slots);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
