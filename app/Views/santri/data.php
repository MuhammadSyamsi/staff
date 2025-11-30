<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card shadow-sm mb-4">
        <div class="card-body">

          <!-- Data Santri (Collapse) -->
<div class="row">
  <!-- Data Santri -->
  <div class="col-md-6 mb-3">
    <div class="card shadow-sm h-100">
      <div class="card-body">
        <!-- Toggle -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <h5 class="fw-bold mb-0">Data Santri</h5>
          <div class="btn-group btn-group-sm" role="group" id="toggle-group">
            <button type="button" class="btn btn-outline-success active" id="btn-mts">MTs</button>
            <button type="button" class="btn btn-outline-danger" id="btn-ma">MA</button>
          </div>
        </div>

        <!-- Konten MTs -->
        <div id="data-mts">
          <div class="mb-3">
            <span class="h1 text-secondary"><?= $mts ?></span>
            <span class="text-muted">santri</span>
          </div>
          <p class="text-muted mb-2">Distribusi per kelas:</p>
          <div>
            <?php foreach ($kelasmts as $rek): ?>
              <span class="btn btn-outline-primary btn-sm rounded-pill m-1 disabled">
                <?= $rek['kelas']; ?>: <i><?= $rek['hitung']; ?> santri</i>
              </span>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Konten MA (disembunyikan awalnya) -->
        <div id="data-ma" class="d-none">
          <div class="mb-3">
            <span class="h1 text-danger"><?= $ma ?></span>
            <span class="text-muted">santri</span>
          </div>
          <p class="text-muted mb-2">Distribusi per kelas:</p>
          <div>
            <?php foreach ($kelasma as $rekma): ?>
              <span class="btn btn-outline-secondary btn-sm rounded-pill m-1 disabled">
                <?= $rekma['kelas']; ?>: <i><?= $rekma['hitung']; ?> santri</i>
              </span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Total Santri Semua Jenjang -->
  <div class="col-md-6 mb-3">
    <div class="card bg-light border-0 shadow-sm h-100 d-flex align-items-center justify-content-center text-center p-4">
      <div>
        <h6 class="text-muted mb-2">Total Santri Semua Jenjang</h6>
        <h2 class="fw-bold text-warning"><?= $total ?></h2>
      </div>
    </div>
  </div>
</div>

             <div class="row">
<!-- Header Filter -->
<div class="col-12 d-flex justify-content-between align-items-center mb-3">
  <h5 class="fw-bold mb-0">Data Santri</h5>
  <a href="<?= base_url('Santri/download') ?>" class="btn btn-sm btn-outline-primary">
    <i class="bi bi-download"></i> Download
  </a>
</div>

  <!-- Form Filter -->
  <div class="col-12">
    <form id="formFilter" class="row g-2 align-items-end">
      <!-- Jenjang -->
      <div class="col-md-4">
        <label for="filterJenjang" class="form-label mb-0">Jenjang</label>
        <select name="jenjang" id="filterJenjang" class="form-select">
          <option value="">Pilih Jenjang</option>
          <?php foreach ($filterJenjang as $fj): ?>
            <option value="<?= $fj['jenjang']; ?>"><?= $fj['jenjang']; ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Kelas -->
      <div class="col-md-4">
        <label for="filterKelas" class="form-label mb-0">Kelas</label>
        <select name="kelas" id="filterKelas" class="form-select" disabled>
          <option value="">Pilih Kelas</option>
        </select>
      </div>

      <!-- Keyword -->
      <div class="col-md-4">
        <label for="keyword" class="form-label mb-0">Pencarian Nama</label>
        <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Cari Nama..." autocomplete="off">
      </div>
    </form>
  </div>

  <!-- Card AJAX -->
  <div class="col-12 mt-3">
    <div id="cardListSantri">
      <!-- Data akan muncul di sini -->
    </div>
  </div>
</div>


        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
  const kelasByJenjang = <?= json_encode($kelasByJenjang) ?>;
  const form = $('#formFilter');

  $('#filterJenjang').on('change', function () {
    const jenjang = $(this).val();
    let html = '<option value="">Pilih Kelas</option>';

    if (jenjang && kelasByJenjang[jenjang]) {
      kelasByJenjang[jenjang].forEach(k => {
        html += `<option value="${k}">${k}</option>`;
      });
      $('#filterKelas').html(html).prop('disabled', false);
    } else {
      $('#filterKelas').html(html).prop('disabled', true);
    }

    filterSantri();
  });

  $('#filterKelas, #keyword').on('change keyup', function () {
    filterSantri();
  });

  function filterSantri() {
    const kelas = $('#filterKelas').val();
    const keyword = $('#keyword').val().trim();
    const jenjang = $('#filterJenjang').val();

    if (jenjang && kelas || keyword.length > 0) {
      $.ajax({
        type: 'GET',
        url: '<?= base_url('Santri/data') ?>',
        data: form.serialize(),
        success: function (html) {
          $('#cardListSantri').html(html);
        }
      });
    } else {
      $('#cardListSantri').html('');
    }
  }

  filterSantri(); // initial load
});
</script>
<script>
  const btnMts = document.getElementById('btn-mts');
  const btnMa = document.getElementById('btn-ma');
  const dataMts = document.getElementById('data-mts');
  const dataMa = document.getElementById('data-ma');

  btnMts.addEventListener('click', function () {
    btnMts.classList.add('active');
    btnMa.classList.remove('active');
    dataMts.classList.remove('d-none');
    dataMa.classList.add('d-none');
  });

  btnMa.addEventListener('click', function () {
    btnMa.classList.add('active');
    btnMts.classList.remove('active');
    dataMa.classList.remove('d-none');
    dataMts.classList.add('d-none');
  });
</script>


<?= $this->endSection(); ?>