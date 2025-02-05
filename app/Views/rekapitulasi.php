<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboardadmin.css">
<style>
     .btn-search {
        padding: 10px 15px;
        background-color: #130C90;
        color: white;
        font-weight: 600;
    }

    .btn-search:hover {
        background-color: #0C074F;
    }

    #search {
        padding: 10px 20px;
        width: 200px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- ================= ALERT ============= -->
<?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

<!-- kartu judul -->

<!-- kartu judul2 -->
<div class="card title-card">
        <h3 class="card-title bold-text">Rekapitulasi Absensi</h3>
        <div class="card-body">
            <p class="subtitle-card"><em>Total Rekapitulasi</em></p>
            <div class="delete">
                    <form action="<?= site_url('/deleteFoto') ?>" method="post">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus semua foto minggu lalu?')">Hapus Foto</button>
                    </form>
            </div>
        </div>
    
</div>

<!--Form filter tanggal -->
<!-- Form filter tanggal dan search -->

<div class="row mb-2 form-container">
    <div class="filter">
        <form action="<?= site_url('/RekapitulasiAbsen') ?>" method="get" class="d-flex" >
            <input type="date" id="date" name="tanggal" class="form-control date-picker" value="<?= isset($tanggal_pilih) ? $tanggal_pilih : $tanggal_hari_ini ?>">
            <button type="submit" class="btn custom-btn">Tampilkan Data</button>
        </form>
    </div>
    <div class="search-form">
        <form action="<?= site_url('/RekapitulasiAbsen') ?>" method="get" class="d-flex" >
            <input type="text" name="search" id="search" class="form-control" placeholder="Cari Nama ....." value="<?= isset($search) ? $search : '' ?>">
            <button type="submit" class="btn-search">Search</button>
        </form>
    </div>
</div>


<!-- Tabel data presensi -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Jam Masuk</th>
                <th>Jam Keluar</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($data_presensi)): ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Data Tidak Ditemukan</td>
                </tr>
            <?php else: ?>
                <?php
                $nomor = ($currentPage - 1) * $perPage + 1;
                foreach ($data_presensi as $v): ?>
                    <tr>
                        <td><?= $nomor++ ?></td>
                        <td><?= $v['tanggal'] ?></td>
                        <td><?= $v['Nama'] ?></td>
                        <td><?= $v['jam_masuk'] ?></td>
                        <td><?= $v['jam_keluar'] ?></td>
                        <td><?= $v['status'] ?></td>
                        <td>
                            <a href="<?= site_url('RekapitulasiAbsen/detail/' . $v['id_presensi']); ?>" class="btn btn-danger">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="row">
    <div class="col-12 col-md-6">
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="<?= site_url('RekapitulasiAbsen?page=' . ($currentPage - 1) . '&search=' . $search . '&tanggal=' . $tanggal_pilih) ?>">Sebelumnya</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= site_url('RekapitulasiAbsen?page=' . $i . '&search=' . $search . '&tanggal=' . $tanggal_pilih) ?>" class="<?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="<?= site_url('RekapitulasiAbsen?page=' . ($currentPage + 1) . '&search=' . $search . '&tanggal=' . $tanggal_pilih) ?>">Selanjutnya</a>
            <?php endif; ?>
        </div>
    </div>
</div>


<?= $this->endSection() ?>