<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<?php
use App\Models\DetailModel;
$TransferModel = new DetailModel();
$id = $TransferModel->orderBy('id', 'desc')->limit(1)->findColumn('id');
$today = date('Y-m-d');
$i = ($id && count($id)) ? $id[0] + 1 : 1;
?>

<div class="container-fluid">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="mb-4 fw-bold"><i class="bi bi-wallet2 me-1"></i> Pembayaran Tunggakan Alumni</h4>

      <form action="<?= base_url('savealumni') ?>" method="post" id="formPembayaran">
        <?= csrf_field(); ?>
        <input type="hidden" name="id" value="<?= $i ?>">

        <!-- Bagian Identitas -->
        <div class="row mb-3">
          <div class="col-lg-6">
            <label for="nisn" class="form-label">Nama Santri</label>
            <select class="form-select" id="nisn" name="nisn" required>
              <option value="" selected disabled>- Pilih Nama -</option>
              <?php foreach ($cari as $c): ?>
                <option value="<?= $c['nisn'] ?>"><?= $c['nama'] ?></option>
              <?php endforeach; ?>
            </select>
            <input type="hidden" id="nama" name="nama">
            <input type="hidden" id="kelas" name="kelas">
            <input type="hidden" id="program" name="program">
          </div>
          <div class="col-lg-6">
            <label for="tanggal" class="form-label">Tanggal Pembayaran</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $today ?>" required>
          </div>
        </div>

        <!-- Bagian Tunggakan -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Tunggakan SPP</label>
            <input type="number" class="form-control" id="spp" disabled>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tunggakan TL</label>
            <input type="number" class="form-control" id="tunggakantl" disabled>
          </div>
          <div class="col-md-4">
            <label class="form-label">Tunggakan DU</label>
            <input type="number" class="form-control" id="tunggakandu" disabled>
          </div>
        </div>

        <!-- Bagian Pembayaran -->
        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Nominal Pembayaran</label>
            <input type="number" class="form-control" name="saldomasuk" id="saldomasuk" required>
          </div>
          <div class="col-md-4">
            <label class="form-label">Rekening</label>
            <select class="form-select" name="rekening" required>
              <option value="" disabled selected>- Pilih Rekening -</option>
              <option value="Muamalat Salam">Muamalat Salam</option>
              <option value="Jatim Syariah">Jatim Syariah</option>
              <option value="BSI">BSI</option>
              <option value="Uang Saku">Uang Saku</option>
              <option value="Muamalat Yatim">Muamalat Yatim</option>
              <option value="Tunai">Tunai</option>
              <option value="lain-lain">Lain-lain</option>
            </select>
          </div>
          <div class="col-md-4">
            <label class="form-label">Keterangan</label>
            <input type="text" class="form-control" name="keterangan">
          </div>
        </div>

        <!-- Bagian Detail Pemasukan -->
        <div class="row mb-4">
          <div class="col-md-4">
            <label class="form-label">Bayar Daftar Ulang</label>
            <input type="number" class="form-control" name="tunggakandu" value="0">
          </div>
          <div class="col-md-4">
            <label class="form-label">Bayar Tunggakan TL</label>
            <input type="number" class="form-control" name="tunggakantl" value="0">
          </div>
          <div class="col-md-4">
            <label class="form-label">Bayar SPP</label>
            <input type="number" class="form-control" name="tunggakanspp" value="0">
          </div>
          <div class="col-md-4">
            <label class="form-label">Uang Saku</label>
            <input type="number" class="form-control" name="uangsaku" value="0">
          </div>
          <div class="col-md-4">
            <label class="form-label">Infaq</label>
            <input type="number" class="form-control" name="infaq" value="0">
          </div>
          <div class="col-md-4">
            <label class="form-label">Formulir</label>
            <input type="number" class="form-control" name="formulir" value="0">
          </div>
        </div>

        <!-- Riwayat Transaksi -->
        <div class="mb-4">
          <label class="form-label fw-semibold">Riwayat Transaksi Terakhir</label>
          <ul class="list-group" id="riwayat-transaksi"></ul>
        </div>

        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-printer"></i> Buat Kwitansi</button>
      </form>
    </div>
  </div>
</div>

<!-- Script Section -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $('#nisn').select2({ placeholder: "Pilih Nama Alumni" });

  $('#nisn').on('change', function () {
    const id = $(this).val();
    getIdentitas(id).then(data => {
      $('#nama').val(data.nama);
      $('#kelas').val(data.kelas);
      $('#program').val(data.program);
      $('#spp').val(data.tunggakanspp);
      $('#tunggakantl').val(data.tunggakantl);
      $('#tunggakandu').val(data.tunggakandu);
    });

    getTransaksi(id).then(transaksi => {
      const list = $('#riwayat-transaksi');
      list.empty();
      if (transaksi.length === 0) {
        list.append(`<li class="list-group-item">Belum ada transaksi.</li>`);
      } else {
        transaksi.forEach(item => {
          list.append(`
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div>
                <strong>${item.tanggal ?? '-'}</strong><br>
                <small>${item.keterangan ?? '-'}</small>
              </div>
              <div class="text-end">
                <span class="text-muted">${item.rekening}</span><br>
                <strong>${formatRupiah(item.nominal)}</strong>
              </div>
            </li>
          `);
        });
      }
    });
  });

  async function getIdentitas(id) {
    const res = await fetch(`<?= base_url('api/alumni/') ?>${id}`);
    return await res.json();
  }

  async function getTransaksi(id) {
    const res = await fetch(`<?= base_url('api/kedua/') ?>${id}`);
    return await res.json();
  }

  function formatRupiah(angka) {
    if (!angka) return 'Rp0';
    return 'Rp' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }
</script>

<?= $this->endSection(); ?>