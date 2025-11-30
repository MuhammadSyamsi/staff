<?= $this->extend('template'); ?>

<?= $this->section('konten'); ?>

<style>
  .list-group-item-custom {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
    border: 1px solid #eee;
    border-left: 4px solid #28a745;
    background-color: #fff;
    color: #333;
    transition: background-color 0.2s ease-in-out;
    text-decoration: none;
  }

  .list-group-item-custom:hover {
    background-color: #f8f9fa;
    text-decoration: none;
  }

  .list-group-item-custom i {
    margin-right: 1rem;
    font-size: 1.25rem;
    color: #28a745;
  }

  .list-group-item-custom.danger i {
    color: #dc3545;
  }

  .list-group-item-custom.success {
    background-color: #28a745;
    color: white;
  }

  .list-group-item-custom.success:hover {
    background-color: #218838;
    color: white;
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/themify-icons/0.1.2/css/themify-icons.css">

<div class="container-fluid">
  <div class="jumbotron py-4 px-4 bg-white border-left border-success shadow-sm">
    <h1 class="h4 mb-0 text-success d-flex align-items-center">
      <i class="ti ti-download mr-2"></i> Download Laporan
    </h1>
    <p class="text-muted mt-1 mb-0">Silakan pilih jenis laporan yang ingin Anda unduh.</p>
  </div>

  <div class="list-group shadow-sm">

    <a href="./keuangan/keterangan" class="list-group-item-custom">
      <i class="ti ti-clipboard"></i> Keterangan Transaksi
    </a>

    <a href="./keuangan/transaksi" class="list-group-item-custom">
      <i class="ti ti-layout-list"></i> Detail Transaksi
    </a>

    <a href="./keuangan/tunggakan" class="list-group-item-custom danger">
      <i class="ti ti-clock"></i> Tunggakan Santri
    </a>

    <a href="./alumni/tunggakan" class="list-group-item-custom danger">
      <i class="ti ti-user"></i> Tunggakan Alumni
    </a>

    <a href="downloadpsb" class="list-group-item-custom">
      <i class="ti ti-download"></i> Penerimaan Santri Baru
    </a>

  </div>
</div>

<?= $this->endSection(); ?>