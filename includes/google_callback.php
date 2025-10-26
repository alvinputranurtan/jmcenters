<?php

require_once __DIR__.'/config.php';

if (!isset($_GET['code'])) {
    exit('❌ Login gagal: tidak ada kode autentikasi.');
}

// --- Tukar authorization code dengan access token ---
$token_url = 'https://oauth2.googleapis.com/token';

$data = [
    'code' => $_GET['code'],
    'client_id' => GOOGLE_CLIENT_ID,
    'client_secret' => GOOGLE_CLIENT_SECRET,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'grant_type' => 'authorization_code',
];

$options = [
    'http' => [
        'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ],
];

$context = stream_context_create($options);
$response = file_get_contents($token_url, false, $context);
$token_data = json_decode($response, true);

if (!isset($token_data['access_token'])) {
    exit('❌ Gagal mendapatkan token akses Google.');
}

// --- Ambil data user dari Google ---
$user_info = file_get_contents('https://www.googleapis.com/oauth2/v3/userinfo?access_token='.$token_data['access_token']);
$user = json_decode($user_info, true);

if (!$user || !isset($user['email'])) {
    exit('❌ Gagal mengambil data pengguna Google.');
}

// --- Simpan ke session ---
$_SESSION['user'] = [
    'id' => $user['sub'] ?? null,
    'name' => $user['name'] ?? 'Tanpa Nama',
    'email' => $user['email'] ?? '',
    'picture' => $user['picture'] ?? '',
];

// --- Redirect ke halaman Pesananku ---
header('Location: '.BASE_URL.'/index.php?p=orders');
exit;
