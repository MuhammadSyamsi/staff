<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container-fluid mb-4">

  <!-- Filter Atas -->
  <div class="row mb-4 g-3 align-items-end">

    <!-- Filter Tanggal & Rekening -->
    <div class="col-12 col-md-3">
      <div class="card shadow-sm h-100">
        <div class="card-body p-2">
          <input id="tanggal-awal-filter" type="date" class="form-control form-control-sm mb-2"
                 value="<?= esc($tanggalAwal) ?>">
          <input id="tanggal-akhir-filter" type="date" class="form-control form-control-sm mb-2"
                 value="<?= esc($tanggalAkhir) ?>">

          <select id="rekening-filter" class="form-select form-select-sm mb-2">
            <option value="">Rekening</option>
            <?php foreach ($rekeningList as $rek) : ?>
              <option value="<?= esc($rek) ?>"><?= esc($rek) ?></option>
            <?php endforeach; ?>
          </select>

          <select id="program-filter" class="form-select form-select-sm">
            <option value="">Program</option>
            <option value="MANDIRI">MANDIRI</option>
            <option value="BEASISWA">BEASISWA</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Jenis Filter -->
    <div class="col-12 col-md-3">
      <div class="card shadow-sm h-100">
        <div class="card-body p-2">
          <div class="btn-group-vertical w-100" role="group">
            <input type="radio" class="btn-check" name="jenisFilter" id="filterSantri" value="santri" checked>
            <label class="btn btn-outline-success fw-semibold text-start" for="filterSantri">Santri</label>

            <input type="radio" class="btn-check" name="jenisFilter" id="filterPSB" value="psb">
            <label class="btn btn-outline-primary fw-semibold text-start" for="filterPSB">PSB</label>

            <input type="radio" class="btn-check" name="jenisFilter" id="filterAlumni" value="alumni">
            <label class="btn btn-outline-warning fw-semibold text-start" for="filterAlumni">Alumni</label>
          </div>
        </div>
      </div>
    </div>

    <!-- Search -->
    <div class="col-12 col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-body p-2">
          <input id="search-input" class="form-control" type="search" placeholder="🔍 Cari Nama Santri / Keterangan..." autofocus>
        </div>
      </div>
    </div>

    <!-- Tombol Download -->
    <div class="col-12 col-md-2 text-center">
      <button id="download-btn" class="btn btn-success w-100 fw-semibold shadow-sm">
        <i class="bi bi-file-earmark-excel-fill me-2"></i>Download
      </button>
    </div>
  </div>

  <!-- Hasil Data -->
  <div class="row g-3">
    <div class="col-12">
      <div id="hasil-container">
        <!-- Data hasil akan diisi lewat JS -->
        <div class="text-center py-4 text-muted" id="empty-state">
          <i class="bi bi-database fs-1 d-block mb-2"></i>
          <p class="mb-0">Silakan gunakan filter di atas untuk menampilkan data mutasi.</p>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function debounce(func, delay) {
  let timeout;
  return function (...args) {
    clearTimeout(timeout);
    timeout = setTimeout(() => func.apply(this, args), delay);
  };
}

function formatTanggalIndo(tgl) {
  if (!tgl) return "-";
  const d = new Date(tgl);
  return d.toLocaleDateString("id-ID", {
    day: "2-digit", month: "long", year: "numeric"
  });
};

const searchInput = document.getElementById('search-input');
const tanggalAwalFilter = document.getElementById('tanggal-awal-filter');
const tanggalAkhirFilter = document.getElementById('tanggal-akhir-filter');
const rekeningFilter = document.getElementById('rekening-filter');
const programFilter = document.getElementById('program-filter');
const jenisFilter = document.querySelectorAll('input[name="jenisFilter"]');
const hasilContainer = document.getElementById('hasil-container');
const downloadBtn = document.getElementById('download-btn');

const formatRupiah = val =>
  new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(val);

const formatItem = (item, type) => {
  let color = type === 'psb' ? 'primary' : (type === 'santri' ? 'success' : 'warning');

  // Tentukan URL berdasarkan tipe
  let editUrl = '';
  let kwitansiUrl = '';

  switch (type) {
    case 'psb':
      editUrl = `<?= base_url('psb/'); ?>${item.idtrans}`;
      kwitansiUrl = `<?= base_url('kwitansi-psb/'); ?>${item.idtrans}`;
      break;

    case 'santri':
      editUrl = `<?= base_url('edit/'); ?>${item.idtrans}`;
      kwitansiUrl = `<?= base_url('kwitansi/'); ?>${item.idtrans}`;
      break;

    case 'alumni':
      editUrl = `<?= base_url('alumni/'); ?>${item.idtrans}`;
      kwitansiUrl = `<?= base_url('kwitansi-alumni/'); ?>${item.idtrans}`;
      break;
  }

  return `
    <div class="card shadow-sm border-${color} border-start border-3 mb-3">
      <div class="card-body d-flex justify-content-between flex-wrap align-items-start">

        <div class="me-2 flex-grow-1">
          <h6 class="fw-bold mb-1">${item.nama} / ${item.kelas}</h6>
          <small class="text-muted d-block text-nowrap">
            ${formatTanggalIndo(item.tanggal)} • ${item.rekening} • ${formatRupiah(item.saldomasuk)}
          </small>
          <p class="mt-2 mb-0">${item.keterangan || ''}</p>
        </div>

        <div class="dropdown">
          <button class="btn btn-link text-muted p-0" type="button"
                  data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-three-dots-vertical fs-5"></i>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li>
              <a class="dropdown-item text-primary" href="${editUrl}">
                <i class="bi bi-pencil-square me-2"></i>Edit
              </a>
            </li>
            <li>
              <a class="dropdown-item text-danger" href="./delete/${item.idtrans}"
                 onclick="return confirm('Apakah anda sudah mengupdate tunggakannya?');">
                <i class="bi bi-trash me-2"></i>Delete
              </a>
            </li>
            <li>
              <a class="dropdown-item text-success" href="${kwitansiUrl}" target="_blank">
                <i class="bi bi-receipt me-2"></i>Kwitansi
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>`;
};

const doSearch = async () => {
  const keyword = searchInput.value.trim();
  const tanggal_awal = tanggalAwalFilter.value;
  const tanggal_akhir = tanggalAkhirFilter.value;
  const rekening = rekeningFilter.value;
  const program = programFilter.value;
  const jenis = document.querySelector('input[name="jenisFilter"]:checked').value;

  const response = await fetch('/mutasi/search', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
    body: JSON.stringify({ keyword, tanggal_awal, tanggal_akhir, rekening, program, jenis })
  });

  const data = await response.json();

  let results = [];
  if (jenis === 'psb') results = data.psb;
  else if (jenis === 'santri') results = data.santri;
  else results = data.alumni;

  hasilContainer.innerHTML = results.length
    ? results.map(item => formatItem(item, jenis)).join('')
    : `<div class="text-center py-4 text-muted">
         <i class="bi bi-inbox fs-1 d-block mb-2"></i>
         <p class="mb-0">Tidak ada data ditemukan.</p>
       </div>`;
};

// Tombol download
downloadBtn.addEventListener('click', async () => {
  const tanggal_awal = tanggalAwalFilter.value;
  const tanggal_akhir = tanggalAkhirFilter.value;
  const rekening = rekeningFilter.value;
  const program = programFilter.value;
  const jenis = document.querySelector('input[name="jenisFilter"]:checked').value;

  const url = `/mutasi/download?tanggal_awal=${tanggal_awal}&tanggal_akhir=${tanggal_akhir}&rekening=${rekening}&program=${program}&jenis=${jenis}`;
  window.open(url, '_blank');
});

// Event listener
searchInput.addEventListener('input', debounce(doSearch, 500));
tanggalAwalFilter.addEventListener('change', doSearch);
tanggalAkhirFilter.addEventListener('change', doSearch);
rekeningFilter.addEventListener('change', doSearch);
programFilter.addEventListener('change', doSearch);
jenisFilter.forEach(r => r.addEventListener('change', doSearch));

// init default
doSearch();
</script>

<?= $this->endSection(); ?>
