<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<?php
use App\Models\DetailModel;
$TransferModel = new DetailModel();
$id = $TransferModel->orderBy('id', 'desc')->limit(1)->findColumn('id');
$today = date('Y-m-d');
$i = ($id == null) ? 1 : max($id) + 1;
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <h3 class="card-title fw-semibold mb-4">Pembayaran Daftar Ulang PSB</h3>

          <form action="<?= base_url('bayar') ?>" method="post" onsubmit="return disableButton();">
            <?= csrf_field(); ?>

<!--hidden post-->
<input type="hidden" id="saldomasuk_hidden" name="saldomasuk">
<input type="hidden" id="tdu_hidden" name="tdu">
<input type="hidden" id="infaq_hidden" name="infaq">

            <input type="hidden" name="id" value="<?= $i; ?>" />
            <input type="hidden" id="nama" name="nama" />
            <input type="hidden" id="kelas" name="kelas" />

            <div class="row g-3 mb-3">
              <div class="col-lg-6">
                <label for="nisn" class="form-label">Nama</label>
                <select class="form-select" id="nisn" name="nisn" required>
                  <option selected disabled value=""></option>
                  <?php foreach ($cari as $c): ?>
                    <option value="<?= $c['nisn']; ?>"><?= $c['nama']; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-lg-3">
                <label class="form-label">Daftar Ulang</label>
                <input type="text" class="form-control" id="du" name="du" value="0" disabled>
              </div>
              <div class="col-lg-3">
                <label class="form-label">Sisa Daftar Ulang</label>
                <input type="text" class="form-control" id="tunggakandu" name="tunggakandu" value="0" disabled>
              </div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-lg-3">
                <label class="form-label">Nominal</label>
                <input type="text" class="form-control" id="saldomasuk">
              </div>
              <div class="col-lg-3">
                <label class="form-label">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $today; ?>">
              </div>
              <div class="col-lg-3">
                <label class="form-label">Rekening</label>
                <select class="form-select" id="rekening" name="rekening">
                  <option value="Muamalat Salam">Muamalat Salam</option>
                  <option value="Jatim Syariah">Jatim Syariah</option>
                  <option value="BSI">BSI</option>
                  <option value="Uang Saku">Uang Saku</option>
                  <option value="Muamalat Yatim">Muamalat Yatim</option>
                  <option value="Tunai">Tunai</option>
                  <option value="lain-lain">Lain-lain</option>
                </select>
              </div>
              <div class="col-lg-3">
                <label class="form-label">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan">
              </div>
            </div>
            
            <div class="row g-2 mb-4">
  <div class="col-lg-3">
    <button type="button" class="btn btn-success w-100" onclick="pelunasanDU()">Pelunasan Daftar Ulang</button>
  </div>
  <div class="col-lg-3">
    <button type="button" class="btn btn-warning w-100" onclick="angsuranDU()">Angsuran Daftar Ulang</button>
  </div>
</div>

            <div class="card mt-4">
  <div class="card-body">
    <h5 class="card-title">Riwayat Transaksi Terakhir</h5>
    <div id="riwayat-transaksi">
      <p class="text-muted">Memuat data...</p>
    </div>
  </div>
</div>

            <h5 class="card-title fw-semibold mb-3">Detail Pemasukan</h5>
            <div class="row g-3 mb-4">
              <div class="col-lg-6">
                <label class="form-label">Bayar Daftar Ulang</label>
                <input type="text" class="form-control" id="tdu" value="0">
              </div>
              <div class="col-lg-6">
                <label class="form-label">Infaq</label>
                <input type="text" class="form-control" id="infaq" value="0">
              </div>
            </div>

            <button type="submit" class="btn btn-dark" onclick="disableButton()">Buat Kwitansi</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- CDN JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function () {
    // Inisialisasi Select2
    $('#nisn').select2({
      placeholder: "Nama Santri",
      allowClear: true
    });

    // Format angka ribuan
    function formatRibuan(angka) {
      return angka.replace(/\D/g, '')
                  .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateInput(visibleInputId, hiddenInputId) {
      const visibleInput = document.getElementById(visibleInputId);
      const hiddenInput = document.getElementById(hiddenInputId);

      visibleInput.addEventListener('input', function () {
        const raw = this.value.replace(/\D/g, '');
        this.value = formatRibuan(raw);
        hiddenInput.value = raw;
      });
    }

    // Terapkan formatting pada input uang
    updateInput('saldomasuk', 'saldomasuk_hidden');
    updateInput('tunggakandu', 'tdu_hidden');
    updateInput('infaq', 'infaq_hidden');

    // Fungsi: Load Riwayat Transaksi
    function loadRiwayatTransaksi(nisn) {
      const $container = $("#riwayat-transaksi");
      $container.html('<p class="text-muted">Memuat data...</p>');

      $.ajax({
        url: `/api/kedua/${nisn}`,
        method: "GET",
        dataType: "json",
        success: function(data) {
          if (!Array.isArray(data) || data.length === 0) {
            $container.html('<p class="text-danger">Belum ada transaksi ditemukan.</p>');
            return;
          }

          let html = `<div class="list-group">`;

          data.forEach(item => {
            html += `
              <div class="list-group-item">
                <div class="d-flex justify-content-between">
                  <div>
                    <small class="text-muted">${item.tanggal || '-'}</small><br>
                    <strong>${item.keterangan || '-'}</strong>
                  </div>
                  <div>
                    <span class="badge bg-primary">${item.rekening || '-'}</span><br>
                    <strong>Rp ${Number(item.nominal || 0).toLocaleString('id-ID')}</strong>
                  </div>
                </div>
              </div>
            `;
          });

          html += `</div>`;
          $container.html(html);
        },
        error: function() {
          $container.html('<p class="text-danger">Gagal mengambil data transaksi.</p>');
        }
      });
    }

    // Ketika NISN berubah
    $('#nisn').on('change', function () {
      const id = $(this).val();

      if (!id) {
        $('#nama, #kelas').val('');
        $('#du').val('');
        $('#tunggakandu').val('');
        $('#riwayat-transaksi').html('');
        return;
      }

      fetch(`api/psb/${id}`)
        .then(res => res.json())
        .then(data => {
          $('#nama').val(data.nama);
          $('#kelas').val(data.kelas);
          $('#du').val(Number(data.daftarulang).toLocaleString('id-ID'));
          $('#tunggakandu').val(Number(data.tunggakandu).toLocaleString('id-ID'));

          loadRiwayatTransaksi(id);
        });
    });

    // Disable submit saat diklik
function disableButton() {
  $('button[type=submit]').prop('disabled', true);
  return true; // supaya form tetap dikirim
}

    // Tombol Pelunasan
    window.pelunasanDU = function () {
      const tunggakanText = $('#tunggakandu').val().replace(/\D/g, '') || '0';
      const tunggakan = parseInt(tunggakanText);

      $('#saldomasuk').val(formatRibuan(tunggakanText));
      $('#saldomasuk_hidden').val(tunggakan);
      $('#tdu').val(formatRibuan(tunggakanText));
      $('#tdu_hidden').val(tunggakan);
      $('#keterangan').val('Pelunasan Daftar Ulang');
    };

    // Tombol Angsuran
    window.angsuranDU = function () {
      const saldomasukText = $('#saldomasuk').val().replace(/\D/g, '') || '0';
      const nominal = parseInt(saldomasukText);

      $('#tdu').val(formatRibuan(saldomasukText));
      $('#tdu_hidden').val(nominal);
      $('#keterangan').val('Angsuran Daftar Ulang');
    };

  });
</script>



<?= $this->endSection(); ?>