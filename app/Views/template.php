<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>sistaff</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/dh.png" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="<?= base_url('assets/css/mobile-pocco-x3.css'); ?>">

</head>

<body>
  <div class="page-wrapper" id="main-wrapper">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand text-success fw-bold" href="<?= base_url() ?>">SISTAFF</a>

        <div class="d-flex align-items-center gap-3">
          <div class="text-end me-2">
            <h5 class="text-primary my-0">Assalamu'alaikum</h5>
            <p class="mb-0">Ustadz <?= ucfirst(user()->username ?? 'Nama') ?></p>
          </div>
          <div class="dropdown">
            <button class="btn btn-outline-secondary rounded-3" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="bi bi-gear"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownMenuButton" style="min-width: 180px;">
              <li>
                <h6 class="dropdown-header">Menu</h6>
              </li>
              <li><a class="dropdown-item" href="<?= base_url('kantin') ?>"><i class="bi bi-gear me-2"></i>Tools</a></li>
              <li>
              <li><a class="dropdown-item" href="<?= base_url('tentang') ?>"><i class="bi bi-info-circle me-2"></i>Tentang</a></li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
            </ul>
          </div>
        </div>
        </ul>
      </div>
  </div>
  </nav>
  <!-- Body Wrapper -->
  <div class="container-fluid py-4 mb-5">
    <div class="row">
      <!-- Sidebar Card (Desktop Only) -->
      <div class="col-lg-3 d-none d-lg-block">
        <div class="card shadow-sm border-0 rounded-3">
          <div class="card-body p-3">
            <h6 class="text-uppercase text-muted fw-bold mb-3">Navigasi</h6>
            <ul class="nav flex-column sidebar-nav">

              <!-- Santri -->
              <?php $active_santri = in_array(uri_string(), ['data-santri', 'data-psb', 'seragam', 'saku', 'alumni', 'checkin', 'komitmen-pembayaran']) ? 'active' : ''; ?>
              <li class="nav-item mb-2">
                <a class="nav-link px-0 ps-2 <?= $active_santri ?>" data-bs-toggle="collapse" href="#submenuSantri" role="button" aria-expanded="<?= $active_santri ? 'true' : 'false' ?>" aria-controls="submenuSantri">
                  <i class="bi bi-people-fill me-2"></i> Santri
                  <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse <?= $active_santri ? 'show' : '' ?>" id="submenuSantri">
                  <ul class="nav flex-column ms-4 mt-1">
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'data-santri' ? 'active' : '' ?>" href="<?= base_url('data-santri') ?>">Data Santri</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'data-psb' ? 'active' : '' ?>" href="<?= base_url('data-psb') ?>">Data PSB</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'seragam' ? 'active' : '' ?>" href="<?= base_url('seragam') ?>">Seragam</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'saku' ? 'active' : '' ?>" href="<?= base_url('saku') ?>">Saku</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'alumni' ? 'active' : '' ?>" href="<?= base_url('alumni') ?>">Alumni</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'checkin' ? 'active' : '' ?>" href="<?= base_url('checkin') ?>">Check-in</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'komitmen-pembayaran' ? 'active' : '' ?>" href="<?= base_url('komitmen-pembayaran') ?>">Komitmen Pembayaran</a></li>
                  </ul>
                </div>
              </li>

              <!-- Keuangan -->
              <?php $active_keuangan = in_array(uri_string(), ['beranda', 'laporan-pemasukan', 'claim']) ? 'active' : ''; ?>
              <li class="nav-item mb-2">
                <a class="nav-link px-0 ps-2 <?= $active_keuangan ?>" data-bs-toggle="collapse" href="#submenuKeuangan" role="button" aria-expanded="<?= $active_keuangan ? 'true' : 'false' ?>" aria-controls="submenuKeuangan">
                  <i class="bi bi-cash-stack me-2"></i> Keuangan
                  <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse <?= $active_keuangan ? 'show' : '' ?>" id="submenuKeuangan">
                  <ul class="nav flex-column ms-4 mt-1">
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'beranda' ? 'active' : '' ?>" href="<?= base_url('beranda') ?>">Rekap Keuangan</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'laporan-pemasukan' ? 'active' : '' ?>" href="<?= base_url('laporan-pemasukan') ?>">Pemasukan</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'claim' ? 'active' : '' ?>" href="<?= base_url('claim') ?>">Pengeluaran</a></li>
                  </ul>
                </div>
              </li>

              <!-- Pembayaran -->
              <?php $active_pembayaran = in_array(uri_string(), ['riwayat-pembayaran', 'data-tunggakan', 'pembayaran-kewajiban', 'pembayaran-psb', 'pembayaran-alumni']) ? 'active' : ''; ?>
              <li class="nav-item mb-2">
                <a class="nav-link px-0 ps-2 <?= $active_pembayaran ?>" data-bs-toggle="collapse" href="#submenuPembayaran" role="button" aria-expanded="<?= $active_pembayaran ? 'true' : 'false' ?>" aria-controls="submenuPembayaran">
                  <i class="bi bi-wallet2 me-2"></i> Pembayaran
                  <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse <?= $active_pembayaran ? 'show' : '' ?>" id="submenuPembayaran">
                  <ul class="nav flex-column ms-4 mt-1">
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'riwayat-pembayaran' ? 'active' : '' ?>" href="<?= base_url('riwayat-pembayaran') ?>">Data Pembayaran</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'pembayaran-kewajiban' ? 'active' : '' ?>" href="<?= base_url('pembayaran-kewajiban') ?>">Input Kewajiban</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'pembayaran-psb' ? 'active' : '' ?>" href="<?= base_url('pembayaran-psb') ?>">Input PSB</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'pembayaran-alumni' ? 'active' : '' ?>" href="<?= base_url('pembayaran-alumni') ?>">Input Alumni</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'data-tunggakan' ? 'active' : '' ?>" href="<?= base_url('data-tunggakan') ?>">Tunggakan</a></li>
                  </ul>
                </div>
              </li>

              <!-- Guru -->
              <?php $active_guru = in_array(uri_string(), ['guru', 'jadwal-pelajaran', 'validasi', 'rekap']) ? 'active' : ''; ?>
              <li class="nav-item mb-2">
                <a class="nav-link px-0 ps-2 <?= $active_guru ?>" data-bs-toggle="collapse" href="#submenuGuru" role="button" aria-expanded="<?= $active_guru ? 'true' : 'false' ?>" aria-controls="submenuGuru">
                  <i class="bi bi-person-video2 me-2"></i> Guru
                  <i class="bi bi-chevron-down ms-auto small"></i>
                </a>
                <div class="collapse <?= $active_guru ? 'show' : '' ?>" id="submenuGuru">
                  <ul class="nav flex-column ms-4 mt-1">
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'guru' ? 'active' : '' ?>" href="<?= base_url('guru') ?>">Data Guru</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'jadwal-pelajaran' ? 'active' : '' ?>" href="<?= base_url('jadwal-pelajaran') ?>">Jadwal Pelajaran</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'validasi' ? 'active' : '' ?>" href="<?= base_url('validasi') ?>">Absen</a></li>
                    <li><a class="nav-link px-0 ps-2 <?= uri_string() == 'rekap' ? 'active' : '' ?>" href="<?= base_url('rekap') ?>">Rekap Kehadiran</a></li>
                  </ul>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </div>
      <!-- Main Content -->
      <div class="col-lg-9 mt-5">
        <?= $this->renderSection('konten'); ?>
      </div>
    </div>
  </div>

  <!-- Bottom Navigation (Mobile) -->
  <nav class="mobile-nav d-none shadow-lg p-2">
    <div class="nav justify-content-around">

      <!-- Santri Dropdown -->
      <div class="dropdown">
        <a class="nav-link text-center dropdown-toggle" href="#" id="santriMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-people-fill fs-5"></i>
          <div class="small">Santri</div>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="santriMenu">
          <li><a class="dropdown-item" href="<?= base_url('data-santri'); ?>">Data Santri</a></li>
          <li><a class="dropdown-item" href="<?= base_url('data-psb'); ?>">Data PSB</a></li>
          <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modulSantriModal">
              Lainnya
            </a>
          </li>
        </ul>
      </div>

      <!-- Keuangan Dropdown -->
      <div class="dropdown">
        <a class="nav-link text-center dropdown-toggle" href="#" id="keuanganMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-cash-stack fs-5"></i>
          <div class="small">Keuangan</div>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="keuanganMenu">
          <li><a class="dropdown-item" href="<?= base_url('beranda'); ?>">Rekap Keuangan</a></li>
          <li><a class="dropdown-item" href="<?= base_url('laporan-pemasukan'); ?>">Pemasukan</a></li>
          <li><a class="dropdown-item" href="<?= base_url('claim'); ?>">Pengeluaran</a></li>
        </ul>
      </div>

      <!-- Pembayaran Dropdown -->
      <div class="dropdown">
        <a class="nav-link text-center dropdown-toggle" href="#" id="pembayaranMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-wallet2 fs-5"></i>
          <div class="small">Pembayaran</div>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="pembayaranMenu">
          <li><a class="dropdown-item" href="<?= base_url('riwayat-pembayaran'); ?>">Data Pembayaran</a></li>
          <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modulPembayaranModal">
              Input Pembayaran
            </a>
          </li>
          <li><a class="dropdown-item" href="<?= base_url('data-tunggakan'); ?>">Tunggakan</a></li>
        </ul>
      </div>

      <!-- Guru Dropdown -->
      <div class="dropdown">
        <a class="nav-link text-center dropdown-toggle" href="#" id="guruMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-video2 fs-5"></i>
          <div class="small">Guru</div>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="guruMenu">
          <li><a class="dropdown-item" href="<?= base_url('guru'); ?>">Data Guru</a></li>
          <li><a class="dropdown-item" href="<?= base_url('jadwal-pelajaran'); ?>">Jadwal Pelajaran</a></li>
          <li>
            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modulGuruModal">
              Lainnya
            </a>
          </li>
        </ul>
      </div>

    </div>
  </nav>

  </div>

  <!--modal menu santri-->
  <div class="modal fade" id="modulSantriModal" tabindex="-1" aria-labelledby="modulSantriLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow-lg">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modulSantriLabel"><i class="bi bi-grid-3x3-gap-fill me-2"></i> Menu Santri Lainnya</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3 text-center">

            <div class="col-6">
              <a href="<?= base_url('seragam'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-person-badge fs-3 text-primary"></i>
                <div>Seragam</div>
              </a>
            </div>

            <div class="col-6">
              <a href="<?= base_url('saku'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-wallet2 fs-3 text-success"></i>
                <div>Saku</div>
              </a>
            </div>

            <div class="col-6">
              <a href="<?= base_url('alumni'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-mortarboard fs-3 text-warning"></i>
                <div>Alumni</div>
              </a>
            </div>

            <div class="col-6">
              <a href="<?= base_url('checkin'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-card-checklist fs-3 text-danger"></i>
                <div>Check-in</div>
              </a>
            </div>

            <div class="col-12">
              <a href="<?= base_url('komitmen-pembayaran'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-journal-check fs-3 text-info"></i>
                <div>Komitmen Pembayaran</div>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!--modal input Pembayaran-->
  <div class="modal fade" id="modulPembayaranModal" tabindex="-1" aria-labelledby="modulPembayaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow-lg">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modulPembayaranLabel">
            <i class="bi bi-cash-stack me-2"></i> Pilih Jenis Pembayaran
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3 text-center">

            <div class="col-12">
              <a href="<?= base_url('pembayaran-kewajiban'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-wallet2 fs-3 text-primary"></i>
                <div>Kewajiban</div>
              </a>
            </div>

            <div class="col-12">
              <a href="<?= base_url('pembayaran-psb'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-mortarboard fs-3 text-success"></i>
                <div>PSB</div>
              </a>
            </div>

            <div class="col-12">
              <a href="<?= base_url('pembayaran-alumni'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-people fs-3 text-warning"></i>
                <div>Alumni</div>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!--modal menu Guru-->
  <div class="modal fade" id="modulGuruModal" tabindex="-1" aria-labelledby="modulGuruLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content rounded-4 shadow-lg">
        <div class="modal-header border-0">
          <h5 class="modal-title" id="modulGuruLabel">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i> Menu Guru Lainnya
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
        </div>
        <div class="modal-body">
          <div class="row g-3 text-center">

            <div class="col-6">
              <a href="<?= base_url('validasi'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-check2-square fs-3 text-primary"></i>
                <div>Absen</div>
              </a>
            </div>

            <div class="col-6">
              <a href="<?= base_url('rekap'); ?>" class="card shadow-sm border-0 p-3 link-dark text-decoration-none h-100">
                <i class="bi bi-clipboard-data fs-3 text-success"></i>
                <div>Rekap</div>
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Script Libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simplebar@6.2.5/dist/simplebar.min.js"></script>

</body>

</html>