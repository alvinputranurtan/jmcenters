<?php

$page = $_GET['p'] ?? 'home';

$allowed = [
    'home',
    'services',
    'pricing',
    'about',
    'contact',
    'appointment',
    'orders',
    'admin_dashboard',
];

if (!in_array($page, $allowed, true)) {
    $page = 'home';
}

/*
|--------------------------------------------------------------------------
| SEO meta per halaman
| - Sesuaikan description & keywords biar relevan dengan konten.
| - Halaman internal (orders/admin) dibuat noindex.
|--------------------------------------------------------------------------
*/
$seoMap = [
    'home' => [
        'title' => 'JM Center — Wellness & Movement Center',
        'description' => 'Pusat fisioterapi modern untuk nyeri muskuloskeletal, pemulihan pasca operasi, cedera olahraga, dan program koreksi postur.',
        'keywords' => 'JM Center, fisioterapi, rehab, pemulihan, cedera olahraga, koreksi postur',
    ],
    'services' => [
        'title' => 'Layanan Fisioterapi — JM Center',
        'description' => 'Layanan unggulan JM Center: terapi nyeri, rehab pasca operasi, sports injury clinic, koreksi postur, terapi bahu & leher, dan home care.',
        'keywords' => 'layanan fisioterapi, terapi nyeri, rehab, sports injury, koreksi postur, home care',
    ],
    'pricing' => [
        'title' => 'Paket & Harga — JM Center',
        'description' => 'Pilih kunjungan tunggal atau paket bundel hemat untuk program rehabilitasi berkelanjutan di JM Center.',
        'keywords' => 'harga fisioterapi, paket fisioterapi, biaya rehab',
    ],
    'about' => [
        'title' => 'Tentang JM Center',
        'description' => 'JM Center adalah Wellness & Movement Center dengan pendekatan terukur untuk pemulihan gerak, pengurangan nyeri, dan peningkatan kualitas hidup.',
        'keywords' => 'tentang JM Center, wellness center, movement center',
    ],
    'contact' => [
        'title' => 'Kontak — JM Center',
        'description' => 'Hubungi JM Center untuk konsultasi, pertanyaan layanan, dan informasi jadwal.',
        'keywords' => 'kontak JM Center, alamat, whatsapp',
    ],
    'appointment' => [
        'title' => 'Jadwalkan Kunjungan — JM Center',
        'description' => 'Buat jadwal kunjungan dengan mudah. Pilih layanan dan waktu yang tersedia di JM Center.',
        'keywords' => 'booking fisioterapi, jadwal terapi, appointment',
    ],

    // Halaman internal -> jangan diindeks mesin pencari
    'orders' => [
        'title' => 'Pesananku — JM Center',
        'description' => 'Riwayat pesanan Anda di JM Center.',
        'keywords' => '',
        'noindex' => true,
    ],
    'admin_dashboard' => [
        'title' => 'Administrasi — JM Center',
        'description' => 'Dashboard administrasi JM Center.',
        'keywords' => '',
        'noindex' => true,
    ],
];

$meta = $seoMap[$page] ?? [
    'title' => 'JM Center — Wellness & Movement Center',
    'description' => 'Wellness & Movement Center.',
    'keywords' => 'JM Center',
];

require_once __DIR__.'/includes/header.php';
include __DIR__.'/pages/'.$page.'.php';
require_once __DIR__.'/includes/footer.php';
