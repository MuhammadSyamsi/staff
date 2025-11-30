<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-10">

      <div class="card shadow-sm mb-4">
        <div class="card-body position-relative" id="kwitansi-area">

          <!-- Header -->
            <div class="d-flex justify-content-between align-items-center p-3 mb-4 text-white" 
                 style="background: linear-gradient(135deg, #2e7d32, #1b5e20); border-bottom: 4px solid #fbc02d;">
              <div>
                <h4 class="fw-bold mb-0">Kwitansi Pembayaran</h4>
                <small class="text-light">Darul Hijrah Salam<br>Jl. Ketanireng, Prigen, Pasuruan</small>
              </div>
              <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" style="height:60px;">
            </div>

          <!-- Identitas -->
          <p>Assalamu'alaikum Wr. Wb.</p>
          <p>Alhamdulillah, telah kami terima amanah dari Bapak/Ibu Wali Santri atas nama:</p>

          <table class="table table-sm">
            <tr><td><strong>Nama Santri</strong></td><td><?= $transfer['nama']; ?></td></tr>
            <tr><td><strong>Jenjang / Kelas</strong></td><td><?= isset($santri['jenjang']) ? $santri['jenjang'].' / '.$santri['kelas'] : '-' ?></td></tr>
            <tr><td><strong>Tanggal Pembayaran</strong></td><td><?= tanggal_indo($transfer['tanggal']); ?></td></tr>
          </table>

          <p class="mt-4">Dengan rincian sebagai berikut:</p>
          <table class="table table-bordered">
            <thead class="table-light">
              <tr><th>Jumlah Pembayaran</th><th>Rekening</th><th>Keterangan</th></tr>
            </thead>
            <tbody>
              <tr>
                <td><?= format_rupiah($transfer['saldomasuk']); ?></td>
                <td><?= $transfer['rekening']; ?></td>
                <td><?= $transfer['keterangan']; ?></td>
              </tr>
            </tbody>
          </table>

          <!-- Kekurangan -->
          <p class="mt-4">Adapun setelah pembayaran ini, masih terdapat kekurangan kewajiban yang perlu diselesaikan sebagai berikut:</p>
          <ul>
            <li>SPP: <strong><?= format_rupiah(max(0, $santri['tunggakanspp'] ?? 0)); ?></strong></li>
            <!--<li>Tunggakan: <strong><?= format_rupiah(max(0, $santri['tunggakantl'] ?? 0)); ?></strong></li>-->
            <li>Daftar Ulang Kelas 1: <strong><?= format_rupiah(max(0, $santri['tunggakandu'] ?? 0)); ?></strong></li>
            <li>Daftar Ulang Kelas 2: <strong><?= format_rupiah(max(0, $santri['tunggakandu2'] ?? 0)); ?></strong></li>
            <li>Daftar Ulang Kelas 3: <strong><?= format_rupiah(max(0, $santri['tunggakandu3'] ?? 0)); ?></strong></li>
          </ul>

          <!-- Tanda Tangan -->
          <div class="text-end mt-5">
            Mengetahui,<br><br><br>
            <strong>Keuangan Darul Hijrah Salam</strong>
          </div>

        </div>
      </div>

      <!-- Tombol -->
        <div class="d-flex justify-content-end mb-5">
          <button class="btn btn-success" id="btnKwitansi">
            <i class="bi bi-download"></i> Download Kwitansi
          </button>
        </div>

    </div>
  </div>
</div>

<!-- Script download -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
function downloadAndSendWa() {
    const area = document.getElementById('kwitansi-area');

    html2canvas(area).then(canvas => {
        // 1. Download gambar kwitansi
        const link = document.createElement('a');
        link.download = "kwitansi-<?= $transfer['idtrans'] ?>-<?= $transfer['nama'] ?>.png";
        link.href = canvas.toDataURL("image/png");
        link.click();

        // 2. Buka WhatsApp dengan pesan
        const nomor = "<?= $santri['kontak1'] ?>"; // ex: 6281234567890
        const pesan = encodeURIComponent("Jazakallah khoir atas pembayarannya. Semoga sehat selalu dan dilancarkan rizkinya. Aamiin");
        window.open(`https://wa.me/${nomor}?text=${pesan}`, "_blank");
    });
}

document.getElementById('btnKwitansi').addEventListener('click', downloadAndSendWa);
</script>
<?= $this->endSection(); ?>
