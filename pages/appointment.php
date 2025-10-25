<div class="container py-5">
  <h1 class="h3 mb-3">Jadwalkan Fisio</h1>
  <div id="apAlert" class="d-none"></div>
  <form id="appointmentForm" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Nama Lengkap</label>
      <input type="text" name="full_name" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">No. WhatsApp</label>
      <input type="tel" name="phone" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control">
    </div>
    <div class="col-md-6">
      <label class="form-label">Layanan</label>
      <select name="service" class="form-select" required>
        <option value="">Pilih layanan...</option>
        <option>Fisioterapi Nyeri Pinggang</option>
        <option>Rehab Pasca Operasi</option>
        <option>Sports Injury</option>
        <option>Koreksi Postur</option>
        <option>Home Visit</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Tanggal Preferensi</label>
      <input type="date" name="preferred_date" class="form-control" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Jam Preferensi</label>
      <input type="time" name="preferred_time" class="form-control" required>
    </div>
    <div class="col-12">
      <label class="form-label">Catatan</label>
      <textarea name="notes" class="form-control" rows="3" placeholder="Keluhan, alergi, riwayat..."></textarea>
    </div>
    <div class="col-12">
      <button class="btn btn-primary btn-lg" type="submit">Kirim Permintaan</button>
    </div>
  </form>
</div>
