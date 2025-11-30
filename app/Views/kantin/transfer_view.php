<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container mt-3">

  <!-- Card Utama -->
  <div class="card cardku shadow-sm mb-5">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs" id="transferTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="laundry-tab" data-bs-toggle="tab" href="#laundry" role="tab">Laundry</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="nonlaundry-tab" data-bs-toggle="tab" href="#nonlaundry" role="tab">Non-Laundry</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="santri-tab" data-bs-toggle="tab" href="#santri" role="tab">Santri</a>
        </li>
      </ul>
    </div>

    <div class="card-body tab-content">

      <!-- Tab Laundry -->
      <div class="tab-pane fade show active" id="laundry" role="tabpanel">
        <form method="get" class="d-flex gap-2 mb-3">
          <select name="bulan" class="form-select form-select-sm">
            <?php for ($m=1;$m<=12;$m++): ?>
              <option value="<?= $m ?>" <?= (isset($_GET['bulan']) && $_GET['bulan']==$m)?'selected':''; ?>>
                <?= date("F", mktime(0,0,0,$m,10)); ?>
              </option>
            <?php endfor; ?>
          </select>
          <select name="tahun" class="form-select form-select-sm">
            <?php for ($y=date('Y');$y>=2020;$y--): ?>
              <option value="<?= $y ?>" <?= (isset($_GET['tahun']) && $_GET['tahun']==$y)?'selected':''; ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>
        <p><span class="badge bg-success">Total Laundry: <?= count($transferLaundry); ?></span></p>
        <div class="list-group">
          <?php if (!empty($transferLaundry)): ?>
            <?php foreach ($transferLaundry as $row): ?>
              <div class="list-group-item bg-transparent border-0">
                <strong><?= esc($row['nama']); ?></strong><br>
                <small class="text-muted"><?= esc($row['keterangan']); ?></small>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted">Tidak ada data laundry.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Tab Non-Laundry -->
      <div class="tab-pane fade" id="nonlaundry" role="tabpanel">
        <form method="get" class="d-flex gap-2 mb-3">
          <select name="bulan3" class="form-select form-select-sm">
            <?php for ($m=1;$m<=12;$m++): ?>
              <option value="<?= $m ?>" <?= (isset($_GET['bulan3']) && $_GET['bulan3']==$m)?'selected':''; ?>>
                <?= date("F", mktime(0,0,0,$m,10)); ?>
              </option>
            <?php endfor; ?>
          </select>
          <select name="tahun3" class="form-select form-select-sm">
            <?php for ($y=date('Y');$y>=2020;$y--): ?>
              <option value="<?= $y ?>" <?= (isset($_GET['tahun3']) && $_GET['tahun3']==$y)?'selected':''; ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>
        <p><span class="badge bg-danger">Total Non-Laundry: <?= count($transferNonLaundry); ?></span></p>
        <div class="list-group glassy">
          <?php if (!empty($transferNonLaundry)): ?>
            <?php foreach ($transferNonLaundry as $row): ?>
              <div class="list-group-item bg-transparent border-0">
                <strong><?= esc($row['nama'] . '/' . $row['kelas']); ?></strong><br>
                <small class="text-muted"><?= esc($row['keterangan']); ?></small>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted">Tidak ada data Non-Laundry.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Tab Santri -->
      <div class="tab-pane fade" id="santri" role="tabpanel">
        <form method="get" class="d-flex gap-2 mb-3">
          <select name="bulan2" class="form-select form-select-sm">
            <?php for ($m=1;$m<=12;$m++): ?>
              <option value="<?= $m ?>" <?= (isset($_GET['bulan2']) && $_GET['bulan2']==$m)?'selected':''; ?>>
                <?= date("F", mktime(0,0,0,$m,10)); ?>
              </option>
            <?php endfor; ?>
          </select>
          <select name="tahun2" class="form-select form-select-sm">
            <?php for ($y=date('Y');$y>=2020;$y--): ?>
              <option value="<?= $y ?>" <?= (isset($_GET['tahun2']) && $_GET['tahun2']==$y)?'selected':''; ?>><?= $y ?></option>
            <?php endfor; ?>
          </select>
          <button type="submit" class="btn btn-sm btn-primary">Filter</button>
        </form>
        <p><span class="badge bg-info">Total Santri: <?= count($transferSantri); ?></span></p>
        <div class="list-group glassy">
          <?php if (!empty($transferSantri)): ?>
            <?php foreach ($transferSantri as $row): ?>
              <div class="list-group-item d-flex justify-content-between bg-transparent border-0">
                <div>
                  <strong><?= esc($row['nama']); ?></strong><br>
                  <small class="text-muted"><?= esc($row['keterangan']); ?></small>
                </div>
                <span class="badge bg-info">Rp <?= number_format($row['saldomasuk'],0,',','.'); ?></span>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="text-muted">Tidak ada data santri.</p>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

</div>

<?= $this->endSection(); ?>