<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<div class="container-fluid mt-3">
  <h3 class="mb-4">📊 Data Tunggakan</h3>

  <div class="row g-3">

    <!-- Card Santri -->
    <div class="col-lg-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Santri</h5>
          <form id="filterSantri" class="row g-2 mb-3">
            <div class="col-md-3">
              <select class="form-select" name="jenjang">
                <option value="">Pilih Jenjang</option>
                <option value="MTs">MTs</option>
                <option value="MA">MA</option>
              </select>
            </div>
            <div class="col-md-3">
              <select class="form-select" name="kelas">
                <option value="">Pilih Kelas</option>
                <?php for ($i=1; $i<=6; $i++): ?>
                  <option value="<?= $i ?>">Kelas <?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control" name="nama" placeholder="Cari nama santri...">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="table-light">
                <tr class="text-center">
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Jenjang</th>
                  <th>Tunggakan SPP</th>
                  <th>Tunggakan DU</th>
                  <th>Tunggakan DU2</th>
                  <th>Tunggakan DU3</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="dataSantri"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Card PSB -->
    <div class="col-lg-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">PSB</h5>
          <form id="filterPsb" class="row g-2 mb-3">
            <div class="col-md-3">
              <select class="form-select" name="jenjang">
                <option value="">Pilih Jenjang</option>
                <option value="MTs">MTs</option>
                <option value="MA">MA</option>
              </select>
            </div>
            <div class="col-md-3">
              <select class="form-select" name="kelas">
                <option value="">Pilih Kelas</option>
                <?php for ($i=1; $i<=6; $i++): ?>
                  <option value="<?= $i ?>">Kelas <?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control" name="nama" placeholder="Cari nama psb...">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="table-light">
                <tr class="text-center">
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Jenjang</th>
                  <th>Tunggakan SPP</th>
                  <th>Tunggakan DU</th>
                  <th>Tunggakan DU2</th>
                  <th>Tunggakan DU3</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="dataPsb"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Card Alumni -->
    <div class="col-lg-12">
      <div class="card shadow-sm">
        <div class="card-body">
          <h5 class="card-title">Alumni</h5>
          <form id="filterAlumni" class="row g-2 mb-3">
            <div class="col-md-3">
              <select class="form-select" name="jenjang">
                <option value="">Pilih Jenjang</option>
                <option value="MTs">MTs</option>
                <option value="MA">MA</option>
              </select>
            </div>
            <div class="col-md-3">
              <select class="form-select" name="kelas">
                <option value="">Pilih Kelas</option>
                <?php for ($i=1; $i<=6; $i++): ?>
                  <option value="<?= $i ?>">Kelas <?= $i ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="col-md-4">
              <input type="text" class="form-control" name="nama" placeholder="Cari nama alumni...">
            </div>
            <div class="col-md-2">
              <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
          </form>
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead class="table-light">
                <tr class="text-center">
                  <th>Nama</th>
                  <th>Kelas</th>
                  <th>Jenjang</th>
                  <th>Tunggakan SPP</th>
                  <th>Tunggakan DU</th>
                  <th>Tunggakan DU2</th>
                  <th>Tunggakan DU3</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="dataAlumni"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEdit" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="formEdit">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Tunggakan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <input type="hidden" name="id" id="editId">
          <input type="hidden" name="tipe" id="editTipe">

          <div class="col-md-6">
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" id="editNama" name="nama" readonly>
          </div>
          <div class="col-md-3">
            <label class="form-label">Kelas</label>
            <input type="text" class="form-control" id="editKelas" name="kelas" readonly>
          </div>
          <div class="col-md-3">
            <label class="form-label">Jenjang</label>
            <input type="text" class="form-control" id="editJenjang" name="jenjang" readonly>
          </div>

          <div class="col-md-4">
            <label class="form-label">Tunggakan SPP</label>
            <input type="number" class="form-control" id="editSpp" name="tunggakanspp">
          </div>
          <div class="col-md-4">
            <label class="form-label">Tunggakan DU</label>
            <input type="number" class="form-control" id="editDu" name="tunggakandu">
          </div>
          <div class="col-md-4">
            <label class="form-label">Tunggakan DU2</label>
            <input type="number" class="form-control" id="editDu2" name="tunggakandu2">
          </div>
          <div class="col-md-4">
            <label class="form-label">Tunggakan DU3</label>
            <input type="number" class="form-control" id="editDu3" name="tunggakandu3">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Fungsi isi tabel
function loadData(tipe, formId, tableId) {
  $(formId).on('submit', function(e) {
    e.preventDefault();
    let data = $(this).serialize();
    $.post(`/admin/tunggakan/load/${tipe}`, data, function(res) {
      let html = '';
      res.forEach(r => {
        html += `
          <tr>
            <td>${r.nama}</td>
            <td>${r.kelas}</td>
            <td>${r.jenjang}</td>
            <td>${r.tunggakanspp}</td>
            <td>${r.tunggakandu}</td>
            <td>${r.tunggakandu2}</td>
            <td>${r.tunggakandu3}</td>
            <td>
              <button class="btn btn-sm btn-warning"
                onclick="editData('${tipe}', ${r.id}, '${r.nama}', '${r.kelas}', '${r.jenjang}', ${r.tunggakanspp}, ${r.tunggakandu}, ${r.tunggakandu2}, ${r.tunggakandu3})">
                Edit
              </button>
            </td>
          </tr>
        `;
      });
      $(tableId).html(html);
    }, 'json');
  });
}

// Edit data ke modal
function editData(tipe, id, nama, kelas, jenjang, spp, du, du2, du3) {
  $('#editTipe').val(tipe);
  $('#editId').val(id);
  $('#editNama').val(nama);
  $('#editKelas').val(kelas);
  $('#editJenjang').val(jenjang);
  $('#editSpp').val(spp);
  $('#editDu').val(du);
  $('#editDu2').val(du2);
  $('#editDu3').val(du3);

  new bootstrap.Modal(document.getElementById('modalEdit')).show();
}

// Submit edit
$('#formEdit').on('submit', function(e) {
  e.preventDefault();
  $.post('/admin/tunggakan/update', $(this).serialize(), function(res) {
    if (res.success) {
      alert('Data berhasil diperbarui');
      location.reload();
    } else {
      alert('Gagal update');
    }
  }, 'json');
});

// Panggil loader untuk tiap card
$(document).ready(function() {
  loadData('santri', '#filterSantri', '#dataSantri');
  loadData('psb', '#filterPsb', '#dataPsb');
  loadData('alumni', '#filterAlumni', '#dataAlumni');

  // auto trigger saat pertama kali
  $('#filterSantri').trigger('submit');
  $('#filterPsb').trigger('submit');
  $('#filterAlumni').trigger('submit');
});
</script>

<?= $this->endSection(); ?>
