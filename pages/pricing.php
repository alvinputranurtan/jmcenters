<div class="container py-5">
  <h1 class="h3 mb-4">Paket & Harga</h1>
  <div class="row g-4">
    <?php
    $plans = [
      ['Single Visit','Cocok untuk konsultasi awal & evaluasi.','Rp 250.000'],
      ['Paket 4 Sesi','Rencana rehabilitasi jangka pendek.','Rp 900.000'],
      ['Paket 8 Sesi','Hemat untuk program komprehensif.','Rp 1.700.000'],
    ];
    foreach($plans as $p): ?>
    <div class="col-md-4">
      <div class="card h-100 shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title"><?php echo $p[0]; ?></h5>
          <p class="card-text text-muted"><?php echo $p[1]; ?></p>
          <div class="h4"><?php echo $p[2]; ?></div>
          <a href="index.php?p=appointment" class="btn btn-primary mt-3">Booking</a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
