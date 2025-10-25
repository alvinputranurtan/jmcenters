<div class="container py-5">
  <h1 class="h3 mb-4">Layanan Fisioterapi</h1>
  <div class="row g-4">
    <?php
    $items = [
      ['Fisioterapi Muskuloskeletal','Nyeri punggung, leher, bahu, lutut, dll.'],
      ['Rehab Pasca Operasi','Pemulihan setelah ACL, rotator cuff, TKR/THR, dll.'],
      ['Sports Physiotherapy','Cedera olahraga & program performance.'],
      ['Neurological Rehab','Stroke, neuropati, latihan keseimbangan.'],
      ['Postural Correction','Forward head, kyphosis, pelvic tilt.'],
      ['Home Visit','Terapi di rumah untuk kebutuhan khusus.'],
    ];
    foreach($items as $i): ?>
    <div class="col-md-6">
      <div class="p-4 bg-white border rounded-4 h-100">
        <h5 class="mb-1"><?php echo $i[0]; ?></h5>
        <p class="text-muted mb-0"><?php echo $i[1]; ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>
