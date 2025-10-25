<section class="hero">
  <div class="container-fluid px-5">
    <div class="row align-items-center g-4">
      <div class="col-lg-6 text-center">
        <h1 class="display-5 mb-3">Pulihkan Gerak, <span class="text-primary">Nikmati Hidup</span></h1>
        <p class="lead text-muted">Pusat fisioterapi modern untuk nyeri muskuloskeletal, pemulihan pasca operasi, cedera olahraga, hingga program koreksi postur.</p>
        <a class="btn btn-primary btn-lg" href="index.php?p=appointment">Jadwalkan Fisio</a>
        <!-- <a class="btn btn-outline-primary btn-lg ms-2" href="index.php?p=services">Lihat Layanan</a> -->
        <div class="d-flex gap-4 mt-4">
          <!-- <div class="d-flex align-items-center gap-2"><img class="feature-icon" src="assets/img/ReservasiFleksibel.png" alt=""> <small>Reservasi fleksibel</small></div>
          <div class="d-flex align-items-center gap-2"><img class="feature-icon" src="assets/img/TimBerlisensi.png" alt=""> <small>Tim berlisensi</small></div> -->
        </div>
      </div>
      <div class="col-lg-6 text-center">
        <img src="assets/img/MassageHeroPage.png" class="img-fluid" alt="illustration" onerror="this.style.display='none'">
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <h2 class="h3 mb-4">Layanan Unggulan</h2>
    <div class="row g-4">
      <?php
      $services = [
          ['title' => 'Fisioterapi Nyeri Pinggang', 'desc' => 'Terapi manual, penguatan core, edukasi ergonomi.'],
          ['title' => 'Rehab Pasca Operasi', 'desc' => 'Program bertahap untuk pemulihan rentang gerak & kekuatan.'],
          ['title' => 'Sports Injury Clinic', 'desc' => 'Evaluasi biomekanik & return-to-sport protocol.'],
          ['title' => 'Koreksi Postur', 'desc' => 'Assessment postural & latihan korektif individual.'],
          ['title' => 'Terapi Bahu & Leher', 'desc' => 'Mengurangi nyeri & meningkatkan mobilitas.'],
          ['title' => 'Home Care Visit', 'desc' => 'Kunjungan fisioterapis ke rumah Anda.'],
      ];
      foreach ($services as $s) { ?>
      <div class="col-md-6 col-lg-4">
        <div class="card card-service h-100 shadow-sm border-0">
          <div class="card-body">
            <h5 class="card-title"><?php echo $s['title']; ?></h5>
            <p class="card-text text-muted"><?php echo $s['desc']; ?></p>
            <a href="index.php?p=services" class="stretched-link">Pelajari &rarr;</a>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</section>

<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-7">
        <h2 class="h3">Paket & Harga Transparan</h2>
        <p class="text-muted">Pilih kunjungan tunggal atau bundel hemat untuk program rehabilitasi berkelanjutan.</p>
        <a class="btn btn-outline-primary" href="index.php?p=pricing">Lihat Paket</a>
      </div>
      <div class="col-lg-5">
        <div class="p-4 bg-white shadow-sm rounded-4">
          <div class="d-flex justify-content-between"><strong>Kunjungan Single</strong><span>Rp 250.000</span></div>
          <hr>
          <div class="d-flex justify-content-between"><strong>Paket 4x</strong><span>Rp 900.000</span></div>
          <hr>
          <div class="d-flex justify-content-between"><strong>Paket 8x</strong><span>Rp 1.700.000</span></div>
          <small class="text-muted">*Harga contoh — sesuaikan.</small>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Script scroll effect -->
<script>
  window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > window.innerHeight - 80) {
      navbar.classList.add('navbar-scrolled');
    } else {
      navbar.classList.remove('navbar-scrolled');
    }
  });

    // Hamburger rotation
  document.addEventListener('DOMContentLoaded', function() {
    const toggler = document.querySelector('.navbar-toggler');
    toggler.addEventListener('click', function() {
      this.classList.toggle('rotated');
    });
  });
</script>