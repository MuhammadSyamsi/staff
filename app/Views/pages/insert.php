<?= $this->extend('template'); ?>
<?= $this->section('konten'); ?>

<?php
use App\Models\DetailModel;

$TransferModel = new DetailModel();
$id = $TransferModel->orderBy('id', 'desc')->limit(1)->findColumn('id');
$today = date('Y-m-d');
$i = ($id == null) ? 1 : ($id[0] + 1);
?>

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card shadow-sm mb-4">
        <div class="card-body">
          <h3 class="card-title mb-4 fw-bold text-primary">Pembayaran Kewajiban Santri</h3>

          <form action="<?= site_url('save') ?>" method="post">
            <?= csrf_field(); ?>
            <input type="hidden" name="id" value="<?= $i; ?>" />

            <div class="mb-3">
              <select class="form-select" id="namaSantri" name="nisn"></select>
              
<!-- Informasi Tambahan -->
  <span id="info-program" class="badge me-2" style="background-color: #1B4332 !important; display:none;">
    program: -
  </span>
  <span id="info-spp" class="badge me-2" style="background-color: #ffc107 !important; color: #000 !important; display:none;">
    SPP: Rp 0
  </span>
  <span id="info-tunggakan-du" class="badge" style="background-color: #dc3545 !important; display:none;">
    Tunggakan DU: Rp 0
  </span>
              <input type="hidden" id="nisn" name="nisn" />
              <input type="hidden" id="nama" name="nama" />
              <input type="hidden" id="kelas" name="kelas" />
              <input type="hidden" id="program" name="program" />
            </div>

<div class="mb-3" id="tombol" style="display: none;">
  <label class="form-label fw-semibold">Input Otomatis</label>
  <div class="d-flex overflow-auto gap-2 pb-2">
    <button class="btn btn-sm btn-outline-primary flex-shrink-0" onclick="isiSPP()">SPP</button>
    <button class="btn btn-sm btn-outline-secondary flex-shrink-0" onclick="isiDaftarUlang()">Daftar Ulang</button>
    <button class="btn btn-sm btn-outline-success flex-shrink-0" onclick="isiSPPLaundry()">SPP & Laundry</button>
    <button class="btn btn-sm btn-outline-warning flex-shrink-0" onclick="isiSPPDaftarUlang()">SPP & DU</button>
    <button class="btn btn-sm btn-outline-warning flex-shrink-0" onclick="isiSPPLaundryDaftarUlang()">SPP, L & DU</button>
    <button class="btn btn-sm btn-outline-danger flex-shrink-0" onclick="isiAngsuranDU()">Angsuran DU</button>
    <button class="btn btn-sm btn-outline-info flex-shrink-0" onclick="isiSPPAngsuranDU()">SPP & DU</button>
    <button class="btn btn-sm btn-outline-info flex-shrink-0" onclick="isiFormulir()">Formulir</button>
    <button class="btn btn-sm btn-outline-dark flex-shrink-0" onclick="isiLain()">Lain</button>
  </div>
</div>

        <div class="card border-0 shadow-sm mb-3">
              <div class="card-header bg-light fw-bold">Detail Transaksi</div>
              <div class="card-body">
                <div class="row g-3">
                    
                    
                  <div class="col-md-3">
                    <label for="saldomasuk" class="form-label">Nominal</label>
                    <input type="text" class="form-control" id="saldomasuk" required disabled />
                    <input type="hidden" id="saldomasuk_raw" name="saldomasuk" />
                  </div>
                  <div class="col-md-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $today ?>" required />
                  </div>
                  <div class="col-md-3">
                    <label for="rekening" class="form-label">Rekening</label>
                    <select class="form-select" id="rekening" name="rekening" required>
                      <option disabled selected value="">-- Pilih Rekening --</option>
                      <option value="Muamalat Salam">Muamalat Salam</option>
                      <option value="Jatim Syariah">Jatim Syariah</option>
                      <option value="BSI">BSI</option>
                      <option value="Uang Saku">Uang Saku</option>
                      <option value="Muamalat Yatim">Muamalat Yatim</option>
                      <option value="Tunai">Tunai</option>
                      <option value="lain-lain">Lain-lain</option>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <label for="keterangan" class="form-label">Keterangan</label>
                    <input type="text" class="form-control" id="keterangan" name="keterangan" required />
                  </div>
                </div>
              </div>
            </div>

            <!-- Collapse Transaksi Sebelumnya -->
            <div class="accordion mb-3" id="accordionTransaksi">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingSebelumnya">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSebelumnya" aria-expanded="false" aria-controls="collapseSebelumnya">
                    Transaksi Sebelumnya <!--<span class="badge bg-dark text-white ms-2" id="lastket1"></span>-->
                  </button>
                </h2>
                <div id="collapseSebelumnya" class="accordion-collapse collapse show" aria-labelledby="headingSebelumnya" data-bs-parent="#accordionTransaksi">
                  <div class="accordion-body">
                    <?php for ($j = 1; $j <= 3; $j++): ?>
                      <div class="row mb-2">
                        <div class="col-4 col-md-2" id="lasttanggal<?= $j ?>"></div>
                        <div class="col-4 col-md-2" id="lastrek<?= $j ?>"></div>
                        <div class="col-4 col-md-2" id="lastnom<?= $j ?>"></div>
                        <div class="col-12 col-md-6" id="lastket<?= $j ?>"></div>
                      </div>
                    <?php endfor; ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Collapse Detail Pemasukan -->
            <div class="accordion mb-4" id="accordionDetail">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingDetail">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDetail" aria-expanded="false" aria-controls="collapseDetail">
                    Detail Pemasukan
                  </button>
                </h2>
                <div id="collapseDetail" class="accordion-collapse collapse" aria-labelledby="headingDetail" data-bs-parent="#accordionDetail">
                  <div class="accordion-body">
                    <div class="row g-3">
                      <div class="col-md-4">
                        <label for="tunggakandu_form" class="form-label">Bayar Daftar Ulang</label>
                        <input type="text" class="form-control" id="tunggakandu_form" value="0" required />
                        <input type="hidden" id="tunggakandu_form_raw" name="tunggakandu" value="0" />
                      </div>
                      <div class="col-md-4">
                        <label for="tunggakantl_form" class="form-label">Bayar Tunggakan</label>
                        <input type="text" class="form-control" id="tunggakantl_form" value="0" required />
                        <input type="hidden" id="tunggakantl_form_raw" name="tunggakantl" value="0" />
                      </div>
                      <div class="col-md-4">
                        <label for="tunggakanspp" class="form-label">Bayar SPP</label>
                        <input type="text" class="form-control" id="tunggakanspp" value="0" required />
                        <input type="hidden" id="tunggakanspp_raw" name="tunggakanspp" value="0" />
                      </div>
                      <div class="col-md-4">
                        <label for="uangsaku" class="form-label">Uang Saku</label>
                        <input type="text" class="form-control" id="uangsaku" value="0" required />
                        <input type="hidden" id="uangsaku_raw" name="uangsaku" value="0" />
                      </div>
                      <div class="col-md-4">
                        <label for="infaq" class="form-label">Infaq</label>
                        <input type="text" class="form-control" id="infaq" value="0" required />
                        <input type="hidden" id="infaq_raw" name="infaq" value="0" />
                      </div>
                      <div class="col-md-4">
                        <label for="formulir" class="form-label">Formulir</label>
                        <input type="text" class="form-control" id="formulir" value="0" required />
                        <input type="hidden" id="formulir_raw" name="formulir" value="0" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        <button type="submit" class="btn btn-primary w-100"><i class="bi bi-printer"></i> Buat Kwitansi</button>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Input Nominal -->
<div class="modal fade" id="modalNominalDU" tabindex="-1" aria-labelledby="modalNominalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Masukkan Nominal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <input type="number" class="form-control" id="inputNominalDU" placeholder="Contoh: 150000">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnSubmitNominalDU">OK</button>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
let selectedSantri = null;

document.addEventListener('DOMContentLoaded', function () {
$('#namaSantri').select2({
  placeholder: "Cari Nama Santri",
  language: {
    noResults: function () {
      return 'Santri tidak ditemukan';
    },
    searching: function () {
      return 'Mencari...';
    }
  },
  ajax: {
    url: 'api/home',
    dataType: 'json',
    data: function (params) {
      return {
        search: params.term
      };
    },
    processResults: function (data) {
      return {
        results: data.map(s => ({
          id: s.nisn,
          nama: s.nama,
          kelas: s.kelas,
          program: s.program,
          spp: Number(s.spp),
          du: Number(s.tunggakandu),
          text: s.nama
        }))
      };
    },
    cache: true
  },
  templateResult: function (data) {
    if (data.loading) return data.text;
    return $(`
      <div>
        <div style="font-weight: bold;">${data.nama}</div>
        <div style="font-size: 0.9em; color: #888;">
          kelas ${data.kelas} - ${data.program}
        </div>
      </div>
    `);
  },
  templateSelection: function (data) {
    return data.nama || data.text;
  }
});

$('#namaSantri').on('select2:select', function (e) {
  const nisn = e.params.data;
  if ($(this).val()) {
        $('#tombol').show();  // tampilkan tombol
      } else {
        $('#tombol').hide();
      }
  selectedSantri = nisn;
  $('#nisn').val(nisn.id);
  $('#nama').val(nisn.nama);
  $('#kelas').val(nisn.kelas);
  $('#program').val(nisn.program);

  const formattedSPP = typeof nisn.spp === 'number' ? nisn.spp.toLocaleString('id-ID') : '0';
  const formattedTunggakanDU = typeof nisn.du === 'number' ? nisn.du.toLocaleString('id-ID') : '0';

  $('#info-program').text(nisn.program).show();
  $('#info-spp').text('SPP: Rp ' + formattedSPP);
  const tunggakanDU = Number(nisn.du) || 0;
  $('#info-tunggakan-du').text('Tunggakan DU: Rp ' + formattedTunggakanDU);
  
  if (nisn.spp > 0) {
      $('#info-spp').text('SPP: Rp ' + formattedSPP).show();
    } else {
      $('#info-spp').hide();
    }
    
    if (nisn.du > 0) {
      $('#info-tunggakan-du').text('Tunggakan DU: Rp ' + formattedTunggakanDU).show();
    } else {
      $('#info-tunggakan-du').hide();
    }

});

$('#namaSantri').on('select2:select', function (e) {
  const nisn = e.params.data.id;
  
$.ajax({
  url: 'api/kedua/' + nisn,
  method: 'GET',
  dataType: 'json',
  success: function (data) {
    for (let i = 0; i < 3; i++) {
      const transaksi = data[i] || { tanggal: '-', rekening: '-', nominal: 0, keterangan: '-' };

      // Format tanggal ke format Indonesia
      const tanggalIndo = transaksi.tanggal !== '-' ? new Date(transaksi.tanggal).toLocaleDateString('id-ID', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
      }) : '-';

      // Format nominal ke angka ribuan
      const nominalFormatted = Number(transaksi.nominal || 0).toLocaleString('id-ID');

      $('#lasttanggal' + (i + 1)).text(tanggalIndo);
      $('#lastrek' + (i + 1)).text(transaksi.rekening);
      $('#lastnom' + (i + 1)).text('Rp ' + nominalFormatted);
      $('#lastket' + (i + 1)).text(transaksi.keterangan);
    }
  },
  error: function () {
    for (let i = 0; i < 3; i++) {
      $('#lasttanggal' + (i + 1)).text('-');
      $('#lastrek' + (i + 1)).text('-');
      $('#lastnom' + (i + 1)).text('-');
      $('#lastket' + (i + 1)).text('-');
    }
  }
});
});

//-------format input-------
  function formatRibuan(angka) {
    return angka.replace(/\D/g, '')
                .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function updateInput(originalInput, hiddenInput) {
    originalInput.addEventListener('input', function () {
      const raw = this.value.replace(/\D/g, '');
      this.value = formatRibuan(raw);
      hiddenInput.value = raw;
    });
  }

  const saldomasukInput = document.getElementById('saldomasuk');
  const duInput = document.getElementById('tunggakandu_form');
  const tlInput = document.getElementById('tunggakantl_form');
  const sppInput = document.getElementById('tunggakanspp');
  const formulirInput = document.getElementById('formulir');
  const sakuInput = document.getElementById('uangsaku_raw');
  const infaqInput = document.getElementById('infaq');

  const saldomasukRaw = document.getElementById('saldomasuk_raw');
  const duRaw = document.getElementById('tunggakandu_form_raw');
  const tlRaw = document.getElementById('tunggakantl_form_raw');
  const sppRaw = document.getElementById('tunggakanspp_raw');
  const formulirRaw = document.getElementById('formulir_raw');
  const sakuRaw = document.getElementById('uangsaku_raw');
  const infaqRaw = document.getElementById('infaq_raw');

  updateInput(saldomasukInput, saldomasukRaw);
  updateInput(duInput, duRaw);
  updateInput(tlInput, tlRaw);
  updateInput(sppInput, sppRaw);
  updateInput(formulirInput, formulirRaw);
  updateInput(sakuInput, sakuRaw);
  updateInput(infaqInput, infaqRaw);
});

  function formatRupiah(angka) {
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  }

  function isiField(id, value) {
    document.getElementById(id).value = formatRupiah(value);
    document.getElementById(id + '_raw').value = value;
  }

  function isiSPP() {
      const spp = selectedSantri.spp || 0;

    isiField("saldomasuk", spp);
    isiField("tunggakanspp", spp);
    isiField("uangsaku", 0);
    isiField("tunggakandu_form", 0);
    document.getElementById("keterangan").value = "SPP bulan ...";
    $('#keterangan').focus();
      $('#saldomasuk').prop('disabled', true);
  }

  function isiDaftarUlang() {
      const tunggakandu = selectedSantri.du || 0;
    isiField("saldomasuk", tunggakandu);
    isiField("tunggakandu_form", tunggakandu);
    isiField("tunggakanspp", 0);
    isiField("uangsaku", 0);
    document.getElementById("keterangan").value = "Pelunasan daftar ulang";
    $('#keterangan').focus();
      $('#saldomasuk').prop('disabled', true);
  }

  function isiSPPLaundry() {
      const spp = selectedSantri.spp || 0;
    const total = spp + 50000;
    isiField("saldomasuk", total);
    isiField("tunggakanspp", spp);
    isiField("uangsaku", 50000);
    isiField("tunggakandu_form", 0);
    document.getElementById("keterangan").value = "SPP bulan ... dan laundry";
    $('#keterangan').focus();
      $('#saldomasuk').prop('disabled', true);
  }

  function isiSPPDaftarUlang() {
      const spp = selectedSantri.spp || 0;
      const tunggakandu = selectedSantri.du || 0;
    const total = spp + tunggakandu;
    isiField("saldomasuk", total);
    isiField("tunggakanspp", spp);
    isiField("tunggakandu_form", tunggakandu);
    isiField("uangsaku", 0);
    document.getElementById("keterangan").value = "SPP bulan ... dan pelunasan daftar ulang";
    $('#keterangan').focus();
      $('#saldomasuk').prop('disabled', true);
  }

  function isiSPPLaundryDaftarUlang() {
      const spp = selectedSantri.spp || 0;
      const tunggakandu = selectedSantri.du || 0;
    const total = spp + tunggakandu + 50000;
    isiField("saldomasuk", total);
    isiField("tunggakanspp", spp);
    isiField("tunggakandu_form", tunggakandu);
    isiField("uangsaku", 50000);
    document.getElementById("keterangan").value = "SPP bulan ... , laundry dan pelunasan daftar ulang";
    $('#keterangan').focus();
      $('#saldomasuk').prop('disabled', true);
  }

  function isiAngsuranDU() {
      const nominal = parseInt(prompt('masukkan nominal')||0)
    isiField("tunggakandu_form", nominal);
    isiField("saldomasuk", nominal);
    isiField("tunggakanspp", 0);
    isiField("uangsaku", 0);
    document.getElementById("keterangan").value = "Angsuran daftar ulang";
    $('#keterangan').focus();
      $('#saldomasuk').prop('disabled', true);
  }

  function isiSPPAngsuranDU() {
      const nominal = parseInt(prompt('masukkan nominal')||0)
      const spp = selectedSantri.spp || 0;
      if(nominal < spp){
          alert ("nominal kurang dari nilai spp");
          return;
      }
    isiField("tunggakanspp", spp);
    isiField("saldomasuk", nominal);
    isiField("tunggakandu_form", nominal - spp);
    isiField("uangsaku", 0);
    document.getElementById("keterangan").value = "SPP bulan ... dan angsuran daftar ulang";
    $('#keterangan').focus();
      $('#saldomasuk').prop('disabled', true);
  }
  function isiFormulir() {
      $('#saldomasuk').prop('disabled', false);
    document.getElementById("keterangan").value = "Formulir Peserta Santri Baru";
    $('#saldomasuk').focus();
  }
  function isiLain() {
      $('#saldomasuk').prop('disabled', false);
    $('#saldomasuk').focus();
  }
  
</script>

<?= $this->endSection(); ?>

