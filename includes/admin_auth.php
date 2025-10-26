<?php

require_once __DIR__.'/config.php';
if (!isset($_SESSION['admin'])) {
    header('Location: '.BASE_URL.'/index.php');
    exit;
}
