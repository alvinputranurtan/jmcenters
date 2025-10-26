<?php

require_once '../config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

try {
    $pdo = db();

    // cek apakah slot sudah ada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE preferred_date=? AND preferred_time=? AND status != 'cancelled'");
    $stmt->execute([$data['preferred_date'], $data['preferred_time']]);
    if ($stmt->fetchColumn() > 0) {
        throw new Exception('Slot sudah terisi');
    }

    // insert data baru
    $insert = $pdo->prepare('INSERT INTO appointments (full_name, phone, email, service, preferred_date, preferred_time, notes)
                           VALUES (?, ?, ?, ?, ?, ?, ?)');
    $insert->execute([
        $data['full_name'],
        $data['phone'],
        $data['email'],
        $data['service'],
        $data['preferred_date'],
        $data['preferred_time'],
        $data['notes'],
    ]);

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
