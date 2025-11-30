<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container py-4">
  <h4 class="mb-4">📋 Penerimaan Santri Baru</h4>

  <div class="row row-cols-1 row-cols-md-2 g-3">
    <?php
    function badgeStyle($status) {
      return match (strtolower($status)) {
        'diterima' => 'bg-success-subtle text-success',
        'baru' => 'bg-warning-subtle text-warning',
        'mengundurkan diri' => 'bg-danger-subtle text-danger',
        default => 'bg-secondary-subtle text-dark'
      };
    }
    ?>

    <?php foreach ($psb as $p): ?>
      <div class="col">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title d-flex align-items-center gap-2">
              <span class="badge <?= badgeStyle($p['status']) ?>">
                <?= match (strtolower($p['status'])) {
                  'diterima' => '✅',
                  'baru' => '🕒',
                  'mengundurkan diri' => '❌',
                  default => 'ℹ️'
                }; ?>
                <?= ucfirst($p['status']); ?>
              </span>
            </h5>
            <ul class="list-unstyled mt-3">
              <li><strong>Jumlah:</strong> <?= $p['jumlah']; ?></li>
              <li><strong>Kewajiban:</strong> <?= format_rupiah($p['kewajiban']); ?></li>
              <li><strong>Pembayaran:</strong> <?= format_rupiah($p['pembayaran']); ?></li>
              <li><strong>Tunggakan:</strong> <?= format_rupiah($p['totaltunggakan']); ?></li>
            </ul>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <?php if (!empty($psb)): ?>
    <div class="accordion mt-4" id="accordionPsbChart">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingPsbChart">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePsbChart" aria-expanded="false" aria-controls="collapsePsbChart">
            📊 Lihat Grafik Penerimaan Santri Baru
          </button>
        </h2>
        <div id="collapsePsbChart" class="accordion-collapse collapse" aria-labelledby="headingPsbChart">
          <div class="accordion-body">
            <canvas id="chartPsbPie" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <hr class="my-5">

  <h4 class="mb-3">💰 Pemasukan & Ringkasan Tunggakan</h4>
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <p><strong>Pemasukan Bulan Ini:</strong> <?= format_rupiah($jumlah[0]['sum'] ?? 0); ?></p>
      <p><strong>Detail Tunggakan:</strong></p>
      <ul>
        <li>Daftar Ulang:</li>
        <li>- Mandiri: <?= format_rupiah(array_sum(array_column($detailtung, 'tungdu'))); ?></li>
        <li>- Beasiswa: <?= format_rupiah(array_sum(array_column($detailbea, 'tungdu'))); ?></li>
        <li><strong>Total DU:</strong> <?= format_rupiah(array_sum(array_column($detailtung, 'tungdu')) + array_sum(array_column($detailbea, 'tungdu'))); ?></li>
        <li><strong>Tahun Lalu:</strong> <?= format_rupiah(array_sum(array_column($detailtung, 'tungtl')) + array_sum(array_column($detailbea, 'tungtl'))); ?></li>
        <li><strong>SPP:</strong> <?= format_rupiah(array_sum(array_column($detailtung, 'tungspp'))); ?></li>
      </ul>
    </div>
  </div>

  <?php if (!empty($detailtung)): ?>
    <div class="accordion mt-4" id="accordionTunggakanChart">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTunggakanChart">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTunggakanChart" aria-expanded="false" aria-controls="collapseTunggakanChart">
            📊 Lihat Grafik Tunggakan & Pemasukan
          </button>
        </h2>
        <div id="collapseTunggakanChart" class="accordion-collapse collapse" aria-labelledby="headingTunggakanChart">
          <div class="accordion-body">
            <canvas id="chartTunggakanPie" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>

<?= $this->endSection(); ?>
