<div class="container py-5">
  <h1 class="h3 mb-3">Jadwalkan Fisio</h1>
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

    <div class="col-md-6">
      <label class="form-label">Tanggal Terapi</label>
      <input id="datePicker" name="preferred_date" type="text" class="form-control" placeholder="Pilih tanggal" required>
    </div>

    <div class="col-md-6">
      <label class="form-label">Waktu Terapi</label>
      <div id="timeSlots" class="d-flex flex-wrap gap-2"></div>
    </div>

    <div class="col-12">
      <label class="form-label">Catatan</label>
      <textarea name="notes" class="form-control" rows="3" placeholder="Keluhan, alergi, riwayat..."></textarea>
    </div>

    <!-- hanya butuh hidden untuk waktu -->
    <input type="hidden" name="preferred_time" id="selectedTime">

    <div class="col-12">
      <button class="btn btn-primary btn-lg" type="submit">Kirim Permintaan</button>
    </div>
  </form>
</div>

<script>
  // --- Inisialisasi kalender ---
flatpickr("#datePicker", {
  minDate: "today",
  dateFormat: "Y-m-d",
  defaultDate: "today",
  onChange: function(selectedDates, dateStr) {
    loadTimeSlots(dateStr);
  }
});

// --- Load time slots dari database ---
function loadTimeSlots(date) {
  const slotContainer = document.getElementById('timeSlots');
  slotContainer.innerHTML = '<p>Loading...</p>';

  fetch(`./includes/api/get_slots.php?date=${encodeURIComponent(date)}`)
    .then(res => {
      if (!res.ok) {
        throw new Error(`HTTP error! status: ${res.status}`);
      }
      return res.json();
    })
    .then(slots => {
      slotContainer.innerHTML = "";

      // --- Validasi apakah hasil benar-benar array ---
      if (!Array.isArray(slots)) {
        console.error("Response bukan array:", slots);
        slotContainer.innerHTML = `<p class="text-danger">Terjadi kesalahan: ${
          slots.error || 'Gagal memuat slot dari server.'
        }</p>`;
        return;
      }

      // --- Jika tidak ada slot sama sekali ---
      if (slots.length === 0) {
        slotContainer.innerHTML = "<p>Tidak ada slot untuk tanggal ini.</p>";
        return;
      }

      // --- Render tombol slot ---
      slots.forEach(slot => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.className = `btn ${slot.available ? 'btn-outline-primary' : 'btn-outline-danger'} m-1`;
        btn.textContent = slot.time;
        btn.disabled = !slot.available;

        btn.onclick = () => {
          document.querySelectorAll('#timeSlots button').forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          document.getElementById('selectedTime').value = slot.time;
        };

        slotContainer.appendChild(btn);
      });
    })
    .catch(err => {
      console.error("Fetch error:", err);
      slotContainer.innerHTML = `<p class="text-danger">Gagal memuat data slot (${err.message})</p>`;
    });
}



  // --- Submit Form ---
  document.getElementById("appointmentForm").addEventListener("submit", e => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(e.target));

fetch("./includes/api/create_appointment.php", {
  method: "POST",
  headers: {"Content-Type": "application/json"},
  body: JSON.stringify(data)
})
    .then(res => res.json())
    .then(res => {
      if (res.success) {
        alert("✅ Permintaan berhasil dikirim!");
        e.target.reset();
        loadTimeSlots(data.preferred_date);
      } else {
        alert("❌ " + res.message);
      }
    });
  });

  // --- Jalankan pertama kali ---
  loadTimeSlots(new Date().toISOString().slice(0,10));
</script>
