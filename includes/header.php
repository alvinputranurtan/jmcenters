<?php require_once __DIR__.'/config.php'; ?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo APP_NAME; ?> — <?php echo APP_TAGLINE; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
  </head>
  <body>
  <nav class="navbar navbar-expand-lg bg-soft-blue border-bottom sticky-top py-2">
    <div class="container-fluid px-5">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <img src="assets/img/logo-2(1).png" alt="logo" width="32" onerror="this.style.display='none'">
        <span class="fw-bold fs-5"><?php echo APP_NAME; ?></span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div id="nav" class="collapse navbar-collapse justify-content-end">
        <ul class="navbar-nav align-items-center mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link px-4" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link px-4" href="index.php?p=services">Layanan</a></li>
          <li class="nav-item"><a class="nav-link px-4" href="index.php?p=pricing">Paket</a></li>
          <li class="nav-item"><a class="nav-link px-4" href="index.php?p=about">Tentang</a></li>
          <li class="nav-item"><a class="nav-link px-4" href="index.php?p=contact">Kontak</a></li>
          <li class="nav-item"><a class="btn btn-primary ms-lg-3 px-4" href="index.php?p=appointment">Jadwalkan Fisio</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <main>
