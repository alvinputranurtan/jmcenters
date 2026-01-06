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

// Helper (optional)
function current_url(): string
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? '';
    $uri = $_SERVER['REQUEST_URI'] ?? '/';

    return $scheme.'://'.$host.$uri;
}
