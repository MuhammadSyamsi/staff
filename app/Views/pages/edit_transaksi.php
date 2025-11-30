<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container-fluid pb-5"> <!-- pb-5 untuk ruang di atas bottom nav -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-3 glass-card">
                <div class="card-body">
                    <?php foreach ($edit as $c) : ?>
                        <h4 class="fw-bold text-secondary mb-2">✏️ Edit Transaksi</h4>
                        <h6 class="text-muted mb-4"><?= $c['nama']; ?></h6>

                        <form action="<?= base_url('edit'); ?>" method="post" class="needs-validation" novalidate>
                            <?= csrf_field(); ?>

                            <!-- Input Utama -->
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label for="saldomasuk" class="form-label small">Saldo Masuk</label>
                                    <input type="text" class="form-control form-control-sm" id="saldomasuk" name="saldomasuk" value="<?= $c['saldomasuk']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal" class="form-label small">Tanggal</label>
                                    <input type="date" class="form-control form-control-sm" id="tanggal" name="tanggal" value="<?= $c['tanggal'] ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="rekening" class="form-label small">Rekening</label>
                                    <select class="form-select form-select-sm" id="rekening" name="rekening">
                                        <option value="<?= $c['rekening'] ?>" selected><?= $c['rekening']; ?></option>
                                        <option>Muamalat Salam</option>
                                        <option>Jatim Syariah</option>
                                        <option>BSI</option>
                                        <option>Uang Saku</option>
                                        <option>Muamalat Yatim</option>
                                        <option>Tunai</option>
                                        <option>Lain-lain</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label for="keterangan" class="form-label small">Keterangan</label>
                                    <input type="text" class="form-control form-control-sm" id="keterangan" name="keterangan" value="<?= $c['keterangan'] ?>" required>
                                    <input type="hidden" name="nama" value="<?= $c['nama']; ?>" />
                                    <input type="hidden" name="idtrans" value="<?= $c['idtrans']; ?>" />
                                    <input type="hidden" name="nisn" value="<?= $c['nisn']; ?>" />
                                    <input type="hidden" name="kelas" value="<?= $c['kelas']; ?>" />
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Tunggakan -->
                        <hr class="my-4"/>
                        <h5 class="fw-bold text-secondary mb-3">📌 Edit Tunggakan</h5>
                        <div class="row g-3">
                            <?php foreach ($santri as $s) : ?>
                                <div class="col-md-4">
                                    <label class="form-label small">Tunggakan Daftar Ulang</label>
                                    <input type="text" class="form-control form-control-sm" id="santridu" name="santridu" value="<?= $s['tunggakandu']; ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Tunggakan Lain-lain</label>
                                    <input type="text" class="form-control form-control-sm" id="santritl" name="santritl" value="<?= $s['tunggakantl']; ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Tunggakan SPP</label>
                                    <input type="text" class="form-control form-control-sm" id="santrispp" name="santrispp" value="<?= $s['tunggakanspp']; ?>" required />
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Detail Pembayaran -->
                        <hr class="my-4"/>
                        <h5 class="fw-bold text-secondary mb-3">💳 Detail Pembayaran</h5>
                        <div class="row g-3">
                            <?php foreach ($detail as $d) : ?>
                                <div class="col-md-4">
                                    <label class="form-label small">Bayar Daftar Ulang</label>
                                    <input type="text" class="form-control form-control-sm" id="du" name="du" value="<?= $d['daftarulang']; ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Bayar Tunggakan</label>
                                    <input type="text" class="form-control form-control-sm" id="tunggakan" name="tunggakan" value="<?= $d['tunggakan']; ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Bayar SPP</label>
                                    <input type="text" class="form-control form-control-sm" id="spp" name="spp" value="<?= $d['spp']; ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Uang Saku</label>
                                    <input type="text" class="form-control form-control-sm" id="uangsaku" name="uangsaku" value="<?= $d['uangsaku']; ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Infaq</label>
                                    <input type="text" class="form-control form-control-sm" id="infaq" name="infaq" value="<?= $d['infaq']; ?>" required />
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Formulir</label>
                                    <input type="text" class="form-control form-control-sm" id="formulir" name="formulir" value="<?= $d['formulir']; ?>" required />
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Tombol Sticky -->
                        <div class="sticky-bottom bg-white py-3 mt-4 d-flex justify-content-between border-top">
                            <a href="<?= base_url('riwayat-pembayaran') ;?>" class="btn btn-sm btn-outline-warning px-4">⬅ Kembali</a>
                            <button type="submit" class="btn btn-sm btn-success px-4">💾 Simpan</button>
                        </div>

                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cleave.js -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const numericFields = [
      'saldomasuk','santridu','santrispp','santritl',
      'du','tunggakan','spp','uangsaku','infaq','formulir'
    ];
    numericFields.forEach(id => {
      const input = document.getElementById(id);
      if (input) {
        new Cleave(input, { numeral: true, numeralThousandsGroupStyle: 'thousand' });
      }
    });
    document.querySelector('form').addEventListener('submit', function () {
      numericFields.forEach(id => {
        const input = document.getElementById(id);
        if (input) input.value = input.value.replace(/\./g, '').replace(/,/g, '');
      });
    });
  });
</script>

<style>
  /* Glass effect untuk card */
  .glass-card {
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(8px);
  }
  /* Padding biar tidak ketutup bottom nav */
  .container-fluid {
    padding-bottom: 5rem !important;
  }
</style>

<?= $this->endSection(); ?>