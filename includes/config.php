<?php

require_once dirname(__DIR__).'/vendor/autoload.php';

// Load .env
$dotenvPath = dirname(__DIR__);
if (file_exists($dotenvPath.'/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($dotenvPath);
    $dotenv->load();
}

// Basic app config
define('APP_NAME', 'JM Center');
define('APP_TAGLINE', 'Wellness & Movement Center');
define('APP_LOCALE', 'id_ID');
date_default_timezone_set('Asia/Jakarta');

// MySQL Database Config
define('DB_HOST', $_ENV['DB_HOST'] ?? 'jmcenters.com');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'jmcenter_database');
define('DB_USER', $_ENV['DB_USER'] ?? 'jmcenter_administrator');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'jmcenterAdmin');

// Auto detect environment
$isLocal = str_contains($_SERVER['HTTP_HOST'], 'localhost');
define('BASE_URL', $isLocal ? 'http://localhost:8080/jmcenters' : 'https://jmcenters.com');

// Google OAuth Config
define('GOOGLE_CLIENT_ID', $_ENV['GOOGLE_CLIENT_ID'] ?? '');
define('GOOGLE_CLIENT_SECRET', $_ENV['GOOGLE_CLIENT_SECRET'] ?? '');
define('GOOGLE_REDIRECT_URI', BASE_URL.'/includes/google_callback.php');

session_start();

function db()
{
    static $pdo = null;
    if ($pdo === null) {
        $pdo = new PDO(
            'mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',
            DB_USER,
            DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}
