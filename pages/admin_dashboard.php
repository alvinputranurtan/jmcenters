<?php
require_once __DIR__.'/../includes/admin_auth.php';

$pdo = db();

// --- Handle Export --- (PINDAH KE ATAS SEBELUM HEADER)
if (isset($_GET['export']) && $_GET['export'] == 'csv') {
    // Bersihkan semua output HTML atau spasi yang mungkin sudah terkirim
    if (ob_get_length()) {
        ob_clean();
    }

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment;filename="appointments.csv"');
    header('Pragma: no-cache');
    header('Expires: 0');

    $out = fopen('php://output', 'w');

    // Tambahkan BOM agar Excel bisa baca UTF-8
    fprintf($out, chr(0xEF).chr(0xBB).chr(0xBF));

    // Header kolom
    fputcsv($out, ['Nama', 'Email', 'Layanan', 'Tanggal', 'Jam', 'Status', 'Catatan']);

    // Isi data
    $stmt = $pdo->query('SELECT full_name, email, service, preferred_date, preferred_time, status, notes FROM appointments');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        fputcsv($out, $row);
    }

    fclose($out); // tutup stream
    exit; // hentikan agar tidak lanjut render HTML
}

require_once __DIR__.'/../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'], $_POST['id'])) {
    $id = intval($_POST['id']);
    $action = $_POST['action'];
    $status = null;

    switch ($action) {
        case 'confirm':
            $status = 'confirmed';
            break;

        case 'cancel':
            $status = 'canceled';
            break;

        case 'pending':
            $status = 'pending';
            break;

        case 'delete':
            $stmt = $pdo->prepare('DELETE FROM appointments WHERE id = ?');
            $stmt->execute([$id]);
            header('Location: '.BASE_URL.'/index.php?p=admin_dashboard&msg=deleted');
            exit;

        default:
            $status = null;
    }

    if ($status !== null) {
        $stmt = $pdo->prepare('UPDATE appointments SET status = ? WHERE id = ?');
        $stmt->execute([$status, $id]);
        header('Location: '.BASE_URL."/index.php?p=admin_dashboard&msg=$status");
        exit;
    }
}

// --- Filter ---
$where = [];
$params = [];

if (!empty($_GET['status'])) {
    $where[] = 'status = ?';
    $params[] = $_GET['status'];
}
if (!empty($_GET['date'])) {
    $where[] = 'preferred_date = ?';
    $params[] = $_GET['date'];
}
$query = 'SELECT * FROM appointments '.(count($where) ? 'WHERE '.implode(' AND ', $where) : '').' ORDER BY created_at DESC';
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// --- Summary ---
$summary = [
    'pending' => $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='pending'")->fetchColumn(),
    'confirmed' => $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='confirmed'")->fetchColumn(),
    'canceled' => $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='canceled'")->fetchColumn(),
];

// --- Alert feedback ---
$msg = $_GET['msg'] ?? null;
$alertMessages = [
    'confirmed' => ['success', '✅ Pesanan dikonfirmasi.'],
    'canceled' => ['warning', '⚠️ Pesanan dibatalkan.'],
    'deleted' => ['danger', '🗑️ Pesanan dihapus.'],
    'pending' => ['info', 'ℹ️ Pesanan dikembalikan ke pending.'],
];
?>

<style>
/* === Tombol aksi admin === */
.d-flex.flex-wrap.gap-1 .btn {
  min-width: 80px;
  text-align: center;
}

/* Mobile layout */
@media (max-width: 768px) {
  td .d-flex {
    flex-direction: row;
    flex-wrap: wrap;
    gap: 4px;
  }
  td .btn {
    flex: 1 1 45%;
    font-size: 0.8rem;
  }
}

/* Badge styling */
.badge.bg-success {
  background-color: #28a745 !important;
}
.badge.bg-danger {
  background-color: #dc3545 !important;
}
.badge.bg-secondary {
  background-color: #6c757d !important;
}

/* Efek fade-out halus */
.alert-custom-fade {
  animation: fadeOut 0.4s ease forwards;
}

@keyframes fadeOut {
  to {
    opacity: 0;
    transform: translateY(-10px);
  }
}
</style>

<div class="container py-5">
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h3 class="mb-0">📋 Manajemen Pesanan</h3>
    <div>
      <a href="<?php echo BASE_URL; ?>/index.php?p=admin_dashboard&export=csv" class="btn btn-outline-secondary btn-sm me-2">📤 Download Laporan</a>
    </div>
  </div>

  <!-- Summary Cards -->
  <div class="row text-center mb-4">
    <div class="col-md-4 mb-3">
      <div class="card border-secondary">
        <div class="card-body">
          <h5>🕓 Pending</h5>
          <h3 class="text-secondary"><?php echo $summary['pending']; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card border-success">
        <div class="card-body">
          <h5>✅ Confirmed</h5>
          <h3 class="text-success"><?php echo $summary['confirmed']; ?></h3>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <div class="card border-danger">
        <div class="card-body">
          <h5>❌ Canceled</h5>
          <h3 class="text-danger"><?php echo $summary['canceled']; ?></h3>
        </div>
      </div>
    </div>
  </div>

  <?php if ($msg && isset($alertMessages[$msg])) { ?>
    <div class="alert alert-<?php echo $alertMessages[$msg][0]; ?> alert-dismissible fade show" role="alert" id="successAlert">
      <?php echo $alertMessages[$msg][1]; ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  <?php } ?>

  <!-- Filter -->
  <form method="get" class="row g-3 align-items-end mb-4">
    <input type="hidden" name="p" value="admin_dashboard">
    <div class="col-md-4">
      <label class="form-label">Status</label>
      <select name="status" class="form-select">
        <option value="">Semua</option>
        <option value="pending" <?php if (($_GET['status'] ?? '') === 'pending') {
            echo 'selected';
        } ?>>Pending</option>
        <option value="confirmed" <?php if (($_GET['status'] ?? '') === 'confirmed') {
            echo 'selected';
        } ?>>Confirmed</option>
        <option value="canceled" <?php if (($_GET['status'] ?? '') === 'canceled') {
            echo 'selected';
        } ?>>Canceled</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Tanggal</label>
      <input type="date" name="date" class="form-control" value="<?php echo htmlspecialchars($_GET['date'] ?? ''); ?>">
    </div>
    <div class="col-md-4 d-flex gap-2">
      <button class="btn btn-primary">Terapkan</button>
      <a href="index.php?p=admin_dashboard" class="btn btn-outline-secondary">Reset</a>
    </div>
  </form>

  <!-- Tabel Data -->
  <?php if (empty($appointments)) { ?>
    <div class="alert alert-info text-center">Tidak ada appointment ditemukan.</div>
  <?php } else { ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light text-center">
          <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Layanan</th>
            <th>Tanggal</th>
            <th>Jam</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($appointments as $i => $a) {
              $statusValue = $a['status'] ?: 'pending';
              $statusClass = match ($statusValue) {
                  'confirmed' => 'success',
                  'canceled' => 'danger',
                  default => 'secondary'
              };
              ?>
          <tr>
            <td class="text-center"><?php echo $i + 1; ?></td>
            <td><?php echo htmlspecialchars($a['full_name']); ?></td>
            <td><?php echo htmlspecialchars($a['email']); ?></td>
            <td><?php echo htmlspecialchars($a['service']); ?></td>
            <td><?php echo htmlspecialchars($a['preferred_date']); ?></td>
            <td><?php echo htmlspecialchars($a['preferred_time']); ?></td>
            <td class="text-center">
              <span class="badge bg-<?php echo $statusClass; ?>">
                <?php echo ucfirst($statusValue); ?>
              </span>
            </td>
            <td class="text-center">
              <div class="d-flex flex-wrap justify-content-center gap-1">
                <?php if ($statusValue !== 'confirmed') { ?>
                  <form method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                    <button name="action" value="confirm" class="btn btn-sm btn-success">
                      Confirm
                    </button>
                  </form>
                <?php } ?>

                <?php if ($statusValue !== 'canceled') { ?>
                  <form method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                    <button name="action" value="cancel" class="btn btn-sm btn-warning">
                      Cancel
                    </button>
                  </form>
                <?php } ?>

                <?php if ($statusValue !== 'pending') { ?>
                  <form method="post" class="d-inline">
                    <input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                    <button name="action" value="pending" class="btn btn-sm btn-outline-secondary">
                      Revert
                    </button>
                  </form>
                <?php } ?>

                <form method="post" class="d-inline" onsubmit="return confirm('Hapus pesanan ini?');">
                  <input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                  <button name="action" value="delete" class="btn btn-sm btn-outline-danger">
                    Delete
                  </button>
                </form>
              </div>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  <?php } ?>
</div>

<script>
// Hilangkan alert otomatis setelah 5 detik
(function() {
  const alertBox = document.getElementById('successAlert');
  if (alertBox) {
    setTimeout(function() {
      alertBox.classList.add('alert-custom-fade');
      setTimeout(function() {
        alertBox.remove();
      }, 400);
    }, 5000);
  }
})();
</script>

<?php require_once __DIR__.'/../includes/footer.php'; ?>