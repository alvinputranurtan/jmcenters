<?php

require_once __DIR__.'/includes/config.php';

// --- routing ---
$page = $_GET['p'] ?? 'home';

$allowed = [
    'home', 'services', 'pricing', 'about', 'contact',
    'appointment', 'orders', 'admin_dashboard',
];

if (!in_array($page, $allowed, true)) {
    http_response_code(404);
    $page = 'home';
}

// --- base meta defaults ---
$baseTitle = APP_NAME.' — '.APP_TAGLINE;
$baseDesc = 'Pusat fisioterapi modern untuk nyeri muskuloskeletal, pemulihan pasca operasi, cedera olahraga, hingga program koreksi postur.';
$baseUrl = rtrim(BASE_URL, '/');

// Canonical untuk routing index.php?p=...
$canonical = $baseUrl.'/index.php'.($page !== 'home' ? ('?p='.urlencode($page)) : '');

// OG Image: pastikan file ini ada (kalau belum, pakai logo.png dulu)
$ogImage = $baseUrl.'/assets/img/logo.png';

// --- per-page meta ---
$metaMap = [
    'home' => [
        'title' => $baseTitle,
        'description' => $baseDesc,
        'canonical' => $baseUrl.'/',
        'noindex' => false,
    ],
    'services' => [
        'title' => 'Layanan Fisioterapi — '.APP_NAME,
        'description' => 'Layanan fisioterapi: nyeri pinggang, rehab pasca operasi, sports injury, koreksi postur, terapi bahu/leher, dan home care visit.',
        'canonical' => $canonical,
        'noindex' => false,
    ],
    'pricing' => [
        'title' => 'Paket & Harga — '.APP_NAME,
        'description' => 'Informasi paket dan harga terapi yang transparan. Pilih kunjungan single atau paket hemat untuk program rehabilitasi.',
        'canonical' => $canonical,
        'noindex' => false,
    ],
    'about' => [
        'title' => 'Tentang — '.APP_NAME,
        'description' => 'Tentang JM Center. Fokus pada pemulihan gerak, pencegahan cedera, edukasi pasien, dan program terapi berbasis evaluasi.',
        'canonical' => $canonical,
        'noindex' => false,
    ],
    'contact' => [
        'title' => 'Kontak — '.APP_NAME,
        'description' => 'Hubungi JM Center untuk konsultasi dan jadwal terapi. Alamat, WhatsApp, email, dan informasi kontak lainnya.',
        'canonical' => $canonical,
        'noindex' => false,
    ],

    // halaman yang boleh kamu pilih: mau diindeks atau tidak.
    // appointment biasanya bagus DIINDEKS karena jadi landing "Jadwalkan".
    'appointment' => [
        'title' => 'Jadwalkan Fisio — '.APP_NAME,
        'description' => 'Jadwalkan sesi fisioterapi di JM Center. Pilih layanan, tanggal, jam, dan isi data kontak.',
        'canonical' => $canonical,
        'noindex' => false,
    ],

    // INTERNAL/PRIVAT: jangan diindeks
    'orders' => [
        'title' => 'Pesananku — '.APP_NAME,
        'description' => 'Halaman akun pengguna.',
        'canonical' => $canonical,
        'noindex' => true,
    ],
    'admin_dashboard' => [
        'title' => 'Administrasi — '.APP_NAME,
        'description' => 'Halaman administrasi.',
        'canonical' => $canonical,
        'noindex' => true,
    ],
];

// meta aktif
$meta = $metaMap[$page] ?? [
    'title' => $baseTitle,
    'description' => $baseDesc,
    'canonical' => $canonical,
    'noindex' => false,
];

$meta['og_image'] = $ogImage;

// Include header/footer
require_once __DIR__.'/includes/header.php';
include __DIR__.'/pages/'.$page.'.php';
require_once __DIR__.'/includes/footer.php';
