<?php

require_once __DIR__.'/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // 🔒 Ganti ini dengan kredensial real
    $admin_user = 'jmadmin';
    $admin_pass = 'secure123';

    if ($username === $admin_user && $password === $admin_pass) {
        $_SESSION['admin'] = [
            'username' => $username,
            'role' => 'admin',
        ];
        header('Location: '.BASE_URL.'/index.php?p=admin_dashboard');
        exit;
    } else {
        header('Location: '.BASE_URL.'/index.php?error=login_failed');
        exit;
    }
}
