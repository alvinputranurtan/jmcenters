$(function(){
  // Smooth scroll for same-page anchors
  $('a[href^="#"]').on('click', function(e){
    const target = $($(this).attr('href'));
    if(target.length){ e.preventDefault(); $('html, body').animate({scrollTop: target.offset().top - 72}, 400); }
  });

  // Appointment form AJAX
  $('#appointmentForm').on('submit', async function(e){
    e.preventDefault();
    const $form = $(this);
    const $btn = $form.find('button[type=submit]');
    $btn.prop('disabled', true).text('Mengirim...');
    try{
      const res = await fetch('appointment_submit.php', { method:'POST', body: new FormData(this)});
      const data = await res.json();
      if(data.ok){
        $form[0].reset();
        $('#apAlert').removeClass('d-none alert-danger').addClass('alert alert-success').text('Permintaan janji temu terkirim. Kami akan menghubungi Anda.');
      }else{
        $('#apAlert').removeClass('d-none alert-success').addClass('alert alert-danger').text(data.error||'Gagal mengirim.');
      }
    }catch(err){
      $('#apAlert').removeClass('d-none alert-success').addClass('alert alert-danger').text('Terjadi masalah jaringan.');
    }finally{
      $btn.prop('disabled', false).text('Kirim Permintaan');
    }
  });
});