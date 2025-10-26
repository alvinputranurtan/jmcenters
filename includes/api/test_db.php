<?php

require_once '../config.php';
try {
    $pdo = db();
    echo '✅ Koneksi berhasil ke DB: '.DB_NAME;
} catch (Exception $e) {
    echo '❌ Error: '.$e->getMessage();
}
