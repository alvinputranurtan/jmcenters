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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
      /* 🔧 Tambahan spacing & perbaikan tampilan mobile */
      @media (max-width: 991px) {
        .navbar-nav .nav-item {
          margin-bottom: 0.75rem;
        }
        .navbar .btn {
          width: 100%;
        }
      }
    </style>
  </head>

  <body>
  <?php
    $isUser = !empty($_SESSION['user']);
$isAdmin = !empty($_SESSION['admin']);
?>

  <nav class="navbar navbar-expand-lg bg-soft-blue border-bottom sticky-top py-2">
    <div class="container-fluid px-4 px-lg-5">
      <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
        <img src="assets/img/logo.png" alt="JM Center Logo" class="logo" onerror="this.style.display='none'">
        <span class="fw-bold fs-5"><?php echo APP_NAME; ?></span>
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div id="nav" class="collapse navbar-collapse justify-content-end mt-3 mt-lg-0">
        <ul class="navbar-nav align-items-lg-center mb-2 mb-lg-0 text-center text-lg-start">

          <!-- Menu utama -->
          <li class="nav-item"><a class="nav-link px-4" href="index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link px-4" href="index.php?p=services">Layanan</a></li>
          <li class="nav-item"><a class="nav-link px-4" href="index.php?p=pricing">Paket</a></li>
          <li class="nav-item"><a class="nav-link px-4" href="index.php?p=about">Tentang</a></li>
          <li class="nav-item"><a class="nav-link px-4" href="index.php?p=contact">Kontak</a></li>

          <!-- Tombol Jadwalkan (tidak tampil untuk admin) -->
          <?php if (!$isAdmin) { ?>
            <li class="nav-item">
              <a class="btn btn-primary ms-lg-3 px-4" href="index.php?p=appointment">Jadwalkan Massage</a>
            </li>
          <?php } ?>

          <!-- Tombol Pesananku (untuk user login via Google) -->
          <?php if ($isUser) { ?>
            <li class="nav-item">
              <a class="btn btn-outline-secondary ms-lg-3 px-3" href="index.php?p=orders">Pesananku</a>
            </li>
          <?php } ?>

          <!-- Tombol Administrasi (untuk admin manual login) -->
          <?php if ($isAdmin) { ?>
            <li class="nav-item">
              <a class="btn btn-danger ms-lg-3 px-3" href="index.php?p=admin_dashboard">Administrasi</a>
            </li>
          <?php } ?>

          <!-- Login / Logout -->
          <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
            <?php if (!$isUser && !$isAdmin) { ?>
              <!-- 🔵 Dropdown login campuran -->
              <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle d-flex align-items-center justify-content-center gap-2 w-100" type="button" data-bs-toggle="dropdown">
                  <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" width="20" height="20">
                  <span>Login</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow p-3" style="min-width: 250px;">
                  <li>
                    <a href="includes/google_login.php" class="dropdown-item d-flex align-items-center gap-2">
                      <img src="https://www.svgrepo.com/show/475656/google-color.svg" width="20" height="20">
                      <span>Login dengan Google</span>
                    </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="<?php echo BASE_URL; ?>/includes/admin_login.php" method="post">
                      <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                      <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                      <button class="btn btn-sm btn-primary w-100">Login Admin</button>
                    </form>
                  </li>
                </ul>
              </div>

            <?php } elseif ($isUser) { ?>
              <!-- 🟢 Profil User (tanpa dropdown nested) -->
              <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
                <img src="<?php echo $_SESSION['user']['picture']; ?>" alt="Profile" width="32" height="32" class="rounded-circle border">
                <span class="fw-semibold small"><?php echo htmlspecialchars($_SESSION['user']['name']); ?></span>
                <a href="includes/logout.php" class="btn btn-outline-danger btn-sm ms-2">Logout</a>
              </div>

            <?php } elseif ($isAdmin) { ?>
              <!-- 🔴 Admin Logout -->
              <a href="includes/logout.php" class="btn btn-outline-danger w-100 w-lg-auto">Logout</a>
            <?php } ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <main>
