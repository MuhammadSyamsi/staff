<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container-fluid mb-5">

  <!-- Judul -->
  <h5 class="mb-3 fw-semibold">📊 Laporan Pemasukan Bulanan</h5>

  <!-- Filter Bulan & Tahun -->
  <form method="get" class="row g-2 mb-4 align-items-center">
    <div class="col-auto">
      <select name="bulan" class="form-select shadow-sm rounded-pill px-3 mx-3">
        <?php for ($i = 1; $i <= 12; $i++): ?>
          <option value="<?= $i; ?>" <?= $i == $bulan ? 'selected' : ''; ?>>
            <?= date('F', mktime(0, 0, 0, $i, 10)); ?>
          </option>
        <?php endfor; ?>
      </select>
    </div>
    <div class="col-auto">
      <select name="tahun" class="form-select shadow-sm rounded-pill px-3 mx-3">
        <?php for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++): ?>
          <option value="<?= $y; ?>" <?= $y == $tahun ? 'selected' : ''; ?>>
            <?= $y; ?>
          </option>
        <?php endfor; ?>
      </select>
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary rounded-pill px-3 mx-3 shadow-sm">
        <i class="bi bi-funnel"></i> Tampilkan
      </button>
    </div>
  </form>

  <!-- Card 1: Rekap Pemasukan Bulanan -->
  <div class="card glass-card mb-4 shadow-sm">
<div class="card-header bg-gradient bg-primary text-white rounded-top-3 d-flex align-items-center">
  <!-- Judul di kiri -->
  <strong>
    Pemasukan per Rekening & Program (<?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)); ?>)
  </strong>
  
  <!-- Navigasi di kanan -->
  <a href="<?= base_url('laporan/downloadBulanan?bulan='.$bulan.'&tahun='.$tahun); ?>" 
     class="btn btn-light btn-sm rounded-pill shadow-sm ms-auto" 
     data-bs-toggle="tooltip" title="Download Laporan Bulanan">
    <i class="bi bi-download"></i>
  </a>
</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Rekening</th>
              <th>Program</th>
              <th class="text-end">Daftar Ulang</th>
              <th class="text-end">Tunggakan</th>
              <th class="text-end">SPP</th>
              <th class="text-end">Uang Saku</th>
              <th class="text-end">Infaq</th>
              <th class="text-end">Formulir</th>
              <th class="text-end">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($detailtrans)): ?>
              <tr>
                <td colspan="9" class="text-center text-muted py-3">
                  <i class="bi bi-emoji-neutral"></i> Belum ada pemasukan pada bulan ini.
                </td>
              </tr>
            <?php else: ?>
              <?php
              $grand = ["daftarulang"=>0,"tunggakan"=>0,"spp"=>0,"saku"=>0,"infaq"=>0,"formulir"=>0,"total"=>0];
              foreach ($detailtrans as $row):
                $total = $row['daftarulang'] + $row['tunggakan'] + $row['spp'] + $row['saku'] + $row['infaq'] + $row['formulir'];
                foreach ($grand as $k => $v) {
                  if ($k !== "total") $grand[$k] += $row[$k];
                }
                $grand["total"] += $total;
              ?>
                <tr>
                  <td><?= esc($row['rekening']); ?></td>
                  <td><?= esc($row['program']); ?></td>
                  <td class="text-end"><?= number_format($row['daftarulang']); ?></td>
                  <td class="text-end"><?= number_format($row['tunggakan']); ?></td>
                  <td class="text-end"><?= number_format($row['spp']); ?></td>
                  <td class="text-end"><?= number_format($row['saku']); ?></td>
                  <td class="text-end"><?= number_format($row['infaq']); ?></td>
                  <td class="text-end"><?= number_format($row['formulir']); ?></td>
                  <td class="text-end fw-bold"><?= number_format($total); ?></td>
                </tr>
              <?php endforeach; ?>
              <tr class="table-secondary fw-bold">
                <td colspan="2" class="text-center">TOTAL</td>
                <td class="text-end"><?= number_format($grand['daftarulang']); ?></td>
                <td class="text-end"><?= number_format($grand['tunggakan']); ?></td>
                <td class="text-end"><?= number_format($grand['spp']); ?></td>
                <td class="text-end"><?= number_format($grand['saku']); ?></td>
                <td class="text-end"><?= number_format($grand['infaq']); ?></td>
                <td class="text-end"><?= number_format($grand['formulir']); ?></td>
                <td class="text-end"><?= number_format($grand['total']); ?></td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Card 2: Rekap Harian -->
  <div class="card glass-card shadow-sm">
<div class="card-header bg-gradient bg-success text-white rounded-top-3 d-flex align-items-center">
  <!-- Judul di kiri -->
  <strong>
    Rekap Harian (<?= date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)); ?>)
  </strong>

  <!-- Navigasi di kanan -->
  <div class="d-flex align-items-center ms-auto">
    <form method="get" class="me-2">
      <input type="hidden" name="bulan" value="<?= $bulan; ?>">
      <input type="hidden" name="tahun" value="<?= $tahun; ?>">
      <select name="rekening" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
        <option value="">Semua Rekening</option>
        <?php foreach ($listRekening as $rek): ?>
          <option value="<?= $rek; ?>" <?= ($rek == ($rekening ?? '')) ? 'selected' : ''; ?>>
            <?= $rek; ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>
    <a href="<?= base_url('laporan/downloadHarian?bulan='.$bulan.'&tahun='.$tahun.($rekening ? '&rekening='.$rekening : '')); ?>" 
       class="btn btn-light btn-sm rounded-pill shadow-sm" 
       data-bs-toggle="tooltip" title="Download Laporan Harian">
      <i class="bi bi-download"></i>
    </a>
  </div>
</div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-sm table-striped align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Tanggal</th>
              <th>Rekening</th>
              <th class="text-end">Total Masuk</th>
            </tr>
          </thead>
          <tbody>
            <?php if (empty($rekapharian ?? [])): ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-3">
                  <i class="bi bi-emoji-frown"></i> Belum ada data harian pada bulan ini.
                </td>
              </tr>
            <?php else: ?>
              <?php 
              $totalHarian = 0;
              foreach ($rekapharian as $row): 
                $totalHarian += $row['total'];
              ?>
                <tr>
                  <td><?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                  <td><?= esc($row['rekening']); ?></td>
                  <td class="text-end fw-semibold"><?= number_format($row['total']); ?></td>
                </tr>
              <?php endforeach; ?>
              <tr class="table-secondary fw-bold">
                <td colspan="2" class="text-center">TOTAL</td>
                <td class="text-end"><?= number_format($totalHarian); ?></td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
<!-- Card 3: Detail Transaksi -->
<!--  <div class="card glass-card shadow-sm mt-4">
    <div class="card-header bg-gradient bg-info text-white rounded-top-3 d-flex align-items-center">
      <strong>
        Detail Transaksi (< ?= date('F Y', mktime(0, 0, 0, $bulan, 1, $Detan)); ?>)
      </strong>

      <!-- Filter Rekening -->
<!--      <div class="d-flex align-items-center ms-auto">
        <form method="get" class="me-2">
          <input type="hidden" name="bulan" value="<= $bulan; ?>">
          <input type="hidden" name="tahun" value="<= $tahun; ?>">
          <select name="rekening" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
            <option value="">Semua Rekening</option>
            < ?php foreach ($listRekening as $rek): ?>
              <option value="<= $rek; ?>" < ?= ($rek == ($rekening ?? '')) ? 'selected' : ''; ?>>
                < ?= $rek; ?>
              </option>
            < ?php endforeach; ?>
          </select>
        </form>
        <a href="< ?= base_url('laporan/downloadDetail?bulan='.$bulan.'&tahun='.$tahun.($rekening ? '&rekening='.$rekening : '')); ?>" 
           class="btn btn-light btn-sm rounded-pill shadow-sm" 
           data-bs-toggle="tooltip" title="Download Detail Transaksi">
          <i class="bi bi-download"></i>
        </a>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-sm table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Tanggal</th>
              <th>Rekening</th>
              <th class="text-end">Total Masuk</th>
            </tr>
          </thead>
          <tbody>
            < ?php if (empty($detaildata ?? [])): ?>
              <tr>
                <td colspan="3" class="text-center text-muted py-3">
                  <i class="bi bi-emoji-expressionless"></i> Tidak ada detail transaksi.
                </td>
              </tr>
            < ?php else: ?>
              < ?php 
              $totalDetail = 0;
              foreach ($detaildata as $row): 
                $totalDetail += $row['total'];
              ?>
                <tr>
                  <td>< ?= date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                  <td><= esc($row['rekening']); ?></td>
                  <td class="text-end fw-semibold">< ?= number_format($row['total']); ?></td>
                </tr>
              < ?php endforeach; ?>
              <tr class="table-secondary fw-bold">
                <td colspan="2" class="text-center">TOTAL</td>
                <td class="text-end">< ?= number_format($totalDetail); ?></td>
              </tr>
            < ?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
-->  
</div>

<?= $this->endSection(); ?>