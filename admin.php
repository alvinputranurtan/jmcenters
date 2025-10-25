<?php require_once __DIR__.'/includes/config.php'; require_once __DIR__.'/includes/header.php';
$pdo = db();
$rows = $pdo->query('SELECT * FROM appointments ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container py-5">
  <h1 class="h3 mb-3">Admin — Appointment Requests</h1>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr>
        <th>#</th><th>Nama</th><th>Kontak</th><th>Layanan</th><th>Preferensi</th><th>Catatan</th><th>Dibuat</th>
      </tr></thead>
      <tbody>
      <?php foreach($rows as $r): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['full_name']); ?></td>
          <td><?php echo htmlspecialchars($r['phone']); ?><br><small class="text-muted"><?php echo htmlspecialchars($r['email']); ?></small></td>
          <td><?php echo htmlspecialchars($r['service']); ?></td>
          <td><?php echo htmlspecialchars($r['preferred_date'].' '.$r['preferred_time']); ?></td>
          <td><?php echo nl2br(htmlspecialchars($r['notes'])); ?></td>
          <td><small class="text-muted"><?php echo $r['created_at']; ?></small></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once __DIR__.'/includes/footer.php'; ?>
