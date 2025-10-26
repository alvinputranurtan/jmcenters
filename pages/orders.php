<?php
require_once __DIR__.'/../includes/config.php';
require_once __DIR__.'/../includes/header.php';

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    echo '<div class="container py-5 text-center">
          <h3>⚠️ Kamu belum login</h3>
          <p>Silakan <a href="'.BASE_URL.'/includes/google_login.php" class="btn btn-primary mt-3">Login dengan Google</a></p>
        </div>';
    require_once __DIR__.'/../includes/footer.php';
    exit;
}

$user = $_SESSION['user'];
$email = $user['email'];

// Ambil data appointment user dari database
try {
    $pdo = db();
    $stmt = $pdo->prepare('SELECT * FROM appointments WHERE email = ? ORDER BY preferred_date DESC, preferred_time ASC');
    $stmt->execute([$email]);
    $appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $appointments = [];
}
?>

<div class="container py-5">
  <div class="text-center mb-5">
    <img src="<?php echo htmlspecialchars($user['picture']); ?>" alt="User Photo" class="rounded-circle mb-3" width="100" height="100">
    <h4 class="fw-semibold"><?php echo htmlspecialchars($user['name']); ?></h4>
    <p class="text-muted"><?php echo htmlspecialchars($user['email']); ?></p>
    
  </div>

  <hr class="my-5">

  <h5 class="mb-4 fw-bold">📅 Daftar Jadwal Terapi Kamu</h5>

  <?php if (empty($appointments)) { ?>
    <div class="alert alert-info text-center">
      Belum ada jadwal terapi yang tercatat.
      <br><a href="<?php echo BASE_URL; ?>/index.php?p=appointment" class="btn btn-primary mt-3">Buat Jadwal Baru</a>
    </div>
  <?php } else { ?>
    <?php foreach ($appointments as $a) { ?>
      <div class="card shadow-sm mb-3">
        <div class="card-body">
          <h6 class="fw-semibold mb-1"><?php echo htmlspecialchars($a['service']); ?></h6>
          <p class="text-muted mb-1">Tanggal: <?php echo htmlspecialchars($a['preferred_date']); ?></p>
          <p class="text-muted mb-1">Waktu: <?php echo htmlspecialchars($a['preferred_time']); ?></p>
          <p class="text-muted mb-1">Catatan: <?php echo htmlspecialchars($a['notes'] ?? '-'); ?></p>
          <span class="badge bg-<?php echo $a['status'] === 'confirmed' ? 'success' : ($a['status'] === 'requested' ? 'warning text-dark' : 'secondary'); ?>">
            <?php echo ucfirst($a['status']); ?>
          </span>
        </div>
      </div>
    <?php } ?>
  <?php } ?>
</div>

<?php require_once __DIR__.'/../includes/footer.php'; ?>
