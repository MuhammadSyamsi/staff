<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container-fluid mb-5">

  <?php
  // Siapkan variabel grand total
  $grand = [
    "daftarulang" => 0,
    "tunggakan"   => 0,
    "spp"         => 0,
    "saku"    => 0,
    "infaq"       => 0,
    "formulir"    => 0,
    "total"       => 0,
  ];

  // Hitung ulang grand total (supaya card header bisa pakai)
  if (!empty($detailtrans)) {
    foreach ($detailtrans as $row) {
      $grand["daftarulang"] += $row["daftarulang"];
      $grand["tunggakan"]   += $row["tunggakan"];
      $grand["spp"]         += $row["spp"];
      $grand["saku"]    += $row["saku"];
      $grand["infaq"]       += $row["infaq"];
      $grand["formulir"]    += $row["formulir"];

      $grand["total"] +=
        $row["daftarulang"] +
        $row["tunggakan"] +
        $row["spp"] +
        $row["saku"] +
        $row["infaq"] +
        $row["formulir"];
    }
  }

  // === Hitung total pemasukan per rekening ===
  $totalRekening = [];

  if (!empty($detailtrans)) {
    foreach ($detailtrans as $row) {
      $total = $row['daftarulang'] + $row['tunggakan'] + $row['spp'] + $row['saku'] + $row['infaq'] + $row['formulir'];
      if (!isset($totalRekening[$row['rekening']])) {
        $totalRekening[$row['rekening']] = 0;
      }
      $totalRekening[$row['rekening']] += $total;
    }
  }
  ?>

  <!-- ==========================
     3 CARD HEADER
=========================== -->
  <div class="row mb-4">

    <!-- CARD 1 -->
    <div class="col-md-4 mb-3">
      <div class="card h-100 shadow-lg border-0">
        <div class="card-header fw-semibold text-white"
          style="background: linear-gradient(135deg, #002b55, #005c9e);">
          Pemasukan Rekening
        </div>
        <div class="card-body" style="background:#f0f8ff;">
          <?php if (empty($totalRekening)): ?>
            <span class="badge bg-secondary d-block text-center py-2">Belum ada data</span>
          <?php else: ?>
            <?php foreach ($totalRekening as $rek => $val): ?>
              <div class="d-flex justify-content-between mb-2">
                <span class="badge bg-primary px-3 py-2"><?= esc($rek); ?></span>
                <span class="badge bg-dark px-3 py-2"><?= number_format($val); ?></span>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="col-md-4 mb-3">
      <div class="card h-100 shadow-lg border-0">
        <div class="card-header fw-semibold text-dark"
          style="background: linear-gradient(135deg, #7fc5ff, #4ea7ff);">
          Pemasukan Item
        </div>
        <div class="card-body" style="background:#eef7ff;">

          <div class="d-flex justify-content-between mb-2">
            <span class="badge bg-info text-dark px-3 py-2">Daftar Ulang</span>
            <span class="badge bg-dark px-3 py-2"><?= number_format($grand['daftarulang']); ?></span>
          </div>

          <div class="d-flex justify-content-between mb-2">
            <span class="badge bg-warning text-dark px-3 py-2">Tunggakan</span>
            <span class="badge bg-dark px-3 py-2"><?= number_format($grand['tunggakan']); ?></span>
          </div>

          <div class="d-flex justify-content-between mb-2">
            <span class="badge bg-success text-white px-3 py-2">SPP</span>
            <span class="badge bg-dark px-3 py-2"><?= number_format($grand['spp']); ?></span>
          </div>

          <div class="d-flex justify-content-between mb-2">
            <span class="badge bg-primary text-white px-3 py-2">Uang Saku</span>
            <span class="badge bg-dark px-3 py-2"><?= number_format($grand['saku']); ?></span>
          </div>

          <div class="d-flex justify-content-between mb-2">
            <span class="badge bg-pink text-white px-3 py-2"
              style="background:#ff4ba8;">Infaq</span>
            <span class="badge bg-dark px-3 py-2"><?= number_format($grand['infaq']); ?></span>
          </div>

          <div class="d-flex justify-content-between">
            <span class="badge bg-purple text-white px-3 py-2"
              style="background:#8a56ff;">Formulir</span>
            <span class="badge bg-dark px-3 py-2"><?= number_format($grand['formulir']); ?></span>
          </div>

        </div>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="col-md-4 mb-3">
      <div class="card h-100 shadow-lg border-0">
        <div class="card-header fw-semibold text-dark"
          style="background: linear-gradient(135deg, #9affb0, #44e368);">
          Total Pemasukan
        </div>
        <div class="card-body d-flex align-items-center justify-content-center"
          style="background:#f1fff3;">
          <h2 class="fw-bold text-success text-center">
            <?= number_format($grand['total']); ?>
          </h2>
        </div>
      </div>
    </div>

  </div>
  <!-- END 3 CARD HEADER -->

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
      <a href="<?= base_url('laporan/downloadBulanan?bulan=' . $bulan . '&tahun=' . $tahun); ?>"
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
              $grand = ["daftarulang" => 0, "tunggakan" => 0, "spp" => 0, "saku" => 0, "infaq" => 0, "formulir" => 0, "total" => 0];
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
        <a href="<?= base_url('laporan/downloadHarian?bulan=' . $bulan . '&tahun=' . $tahun . ($rekening ? '&rekening=' . $rekening : '')); ?>"
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
</div>

<?= $this->endSection(); ?>