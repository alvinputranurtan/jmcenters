<?php require_once __DIR__.'/includes/header.php'; 
$page = $_GET['p'] ?? 'home';
$allowed = ['home','services','pricing','about','contact','appointment'];
if(!in_array($page,$allowed)) $page='home';
include __DIR__ . '/pages/' . $page . '.php';
require_once __DIR__.'/includes/footer.php'; ?>
