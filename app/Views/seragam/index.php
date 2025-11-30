<?php
if (in_groups('superadmin')) {
    echo $this->extend('template');
} else {
    echo $this->extend('template_general');
}
?>

<?= $this->section('konten') ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card shadow-sm mb-4">
        <div class="card-body">

          <h5 class="mb-4"><i class="bi bi-person-check-fill me-1"></i> Data Seragam Santri</h5>

<div class="row mb-3">
    <p class="text-muted small mb-1">
  <i class="bi bi-info-circle"></i> Angka pada label menunjukkan jumlah <strong>seragam yang belum diberikan</strong>
</p>

  <?php foreach ($statistikKelas as $k): ?>
    <div class="col-md-2 mb-2">
      <a href="<?= base_url('seragam?jenjang=' . $k['jenjang'] . '&kelas=' . $k['kelas']) ?>" class="btn btn-sm btn-<?= $filter_kelas == $k['kelas'] ? 'primary' : 'outline-secondary' ?> w-100">
        <?= $k['jenjang'] ?> <?= $k['kelas'] ?>
      <span class="badge bg-danger"><?= $k['total_belum'] ?></span>
      </a>
    </div>
  <?php endforeach; ?>
</div>
<div class="d-flex justify-content-end mb-3">
  <a href="<?= base_url('seragam/downloadcsv') ?>" class="btn btn-sm btn-success">
    <i class="bi bi-download"></i> Download Semua Data (CSV)
  </a>
</div>

<?php if (!$filter_jenjang || !$filter_kelas): ?>
  <div class="alert alert-info text-center">
    <i class="bi bi-funnel-fill"></i> Silakan pilih jenjang dan kelas terlebih dahulu.
  </div>
<?php elseif (empty($santri)): ?>
  <div class="alert alert-warning text-center">
    <i class="bi bi-exclamation-circle"></i> Tidak ada santri ditemukan untuk filter yang dipilih.
  </div>
<?php else: ?>
  <!-- Tabel tampil di sini jika data tersedia -->
  <div class="table-responsive">
    <table class="table table-bordered table-sm">
      <thead class="table-light text-center">
        <tr>
          <th>Nama</th>
          <th>Baju Putih</th>
          <th>Celana Abu</th>
          <th>Baju Batik</th>
          <th>Celana Putih</th>
          <th>Baju Coklat</th>
          <th>Celana Coklat</th>
          <th>Baju Pandu</th>
          <th>Celana Pandu</th>
          <th>Beladiri</th>
          <?php if (in_groups('superadmin')) : ?>
            <th>Aksi</th>
          <?php endif; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($santri as $s): ?>
         <tr>
                    <td><?= esc($s['nama']) ?></td>

                    <?php
                      $seragamMap = [];
                      foreach ($s['seragam'] as $item) {
                        $key = $item['jenis_seragam'] . '-' . $item['kategori'];
                        $seragamMap[$key] = $item;
                      }

                      $itemList = [
                        'baju-putih', 'celana-abu',
                        'baju-batik', 'celana-putih',
                        'baju-coklat', 'celana-coklat',
                        'baju-pandu', 'celana-pandu',
                        'baju-beladiri'
                      ];

                      foreach ($itemList as $key):
                        $data = $seragamMap[$key] ?? null;
                    ?>
                      <td class="text-center">
                        <?php if ($data && $data['status'] == 'sudah_diberikan'): ?>
                          <i class="bi bi-check-square-fill text-success"><text-muted class="ms-2"><?= $data['ukuran'] ?></text-muted></i>
                        <?php else: ?>
                          <i class="bi bi-square text-muted" alt="Belum diberikan" title="Belum diberikan"></i>
                        <?php endif; ?>
                      </td>
                    <?php endforeach; ?>

                    <?php if (in_groups('superadmin')) : ?>
                    <td class="text-center">
                      <!-- Tombol Trigger Modal -->
                        <button 
                          type="button" 
                          class="btn btn-sm btn-outline-primary"
                          data-bs-toggle="modal" 
                          data-bs-target="#modalSeragam-<?= $s['nisn'] ?>">
                          <i class="bi bi-pencil-square"></i>
                        </button>
                    </td>
                    <?php endif; ?>
                  </tr>

<!-- Modal Form Edit Seragam -->
<div class="modal fade" id="modalSeragam-<?= $s['nisn'] ?>" tabindex="-1" aria-labelledby="modalSeragamLabel-<?= $s['nisn'] ?>" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form method="post" action="<?= base_url('seragam/update') ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalSeragamLabel-<?= $s['nisn'] ?>">Edit Seragam - <?= esc($s['nama']) ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="nisn" value="<?= $s['nisn'] ?>">

          <div class="row">
            <?php
              $kategoriList = ['putih', 'abu', 'batik', 'coklat', 'pandu', 'beladiri'];
              $jenisList = ['baju', 'celana'];
              $ukuranList = ['S','M','L','XL','XXL','XXXL'];

              foreach ($kategoriList as $kategori):
                foreach ($jenisList as $jenis):

                  // hanya tampilkan pasangan valid
                  if (
                    ($jenis == 'baju' && in_array($kategori, ['putih','batik','coklat','pandu', 'beladiri'])) ||
                    ($jenis == 'celana' && in_array($kategori, ['abu','putih','coklat','pandu']))
                  ):
                    // cari data seragam terkait
                    $dataSeragam = null;
                    foreach ($s['seragam'] as $seragam) {
                      if ($seragam['kategori'] == $kategori && $seragam['jenis_seragam'] == $jenis) {
                        $dataSeragam = $seragam;
                        break;
                      }
                    }
            ?>
            <div class="col-md-6 mb-3">
              <label><?= ucfirst($jenis) . ' ' . ucfirst($kategori) ?></label>
              <div class="input-group">
                <select name="seragam[<?= $jenis ?>][<?= $kategori ?>][ukuran]" class="form-select">
                  <option value="">- Pilih Ukuran -</option>
                  <?php foreach ($ukuranList as $uk): ?>
                    <option value="<?= $uk ?>" <?= ($dataSeragam && $dataSeragam['ukuran'] == $uk) ? 'selected' : '' ?>>
                      <?= $uk ?>
                    </option>
                  <?php endforeach ?>
                </select>
                <select name="seragam[<?= $jenis ?>][<?= $kategori ?>][status]" class="form-select">
                  <option value="belum" <?= (!$dataSeragam || $dataSeragam['status'] == 'belum') ? 'selected' : '' ?>>Belum</option>
                  <option value="sudah_diberikan" <?= ($dataSeragam && $dataSeragam['status'] == 'sudah_diberikan') ? 'selected' : '' ?>>Sudah</option>
                </select>
              </div>
            </div>
            <?php
                  endif;
                endforeach;
              endforeach;
            ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
      </div>
    </form>
  </div>
</div>

        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
