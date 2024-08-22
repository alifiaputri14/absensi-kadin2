<?= $this->extend('/layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/dashboardadmin.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- kartu judul -->
<div class="card title-card">
    <div class="card-body">
        <h3 class="card-title bold-text">Rekapitulasi</h3>
        <p><em><?= $tanggal_hari_ini ?></em></p>
    </div>
</div>

<!-- container khusus untuk box -->
<div class="box-container">
    <!-- kartu sakit, izin, hadir -->    
    <div class="box box1">
        <p>HADIR</p>
        <h1><?= $total_hadir ?></h1>
    </div>
    <div class="box box2">
        <p>SAKIT</p>
        <h1><?= $total_sakit ?></h1>
    </div>
    <div class="box box3">
        <p>IZIN</p>
        <h1><?= $total_izin ?></h1>
    </div>
    <div class="box box4">
        <p>TOTAL</p>
        <h1><?= $total_rekap ?></h1>
    </div>
</div>

<!-- kartu judul2 -->
<div class="card title-card">
    <div class="card-body">
        <h3 class="card-title bold-text">Rekapitulasi</h3>
        <p><em>Total Rekapitulasi</em></p>
    </div>
</div>

<!-- Form filter tanggal -->
<div class="row mb-2">
    <div class="col-md-12">
        <form action="<?= site_url('DashboardAdmin/Filtertanggal') ?>" method="get" class="d-flex">
            <input type="date" id="date" name="tanggal" class="form-control date-picker" value="<?= isset($tanggal_pilih) ? $tanggal_pilih : $tanggal_hari_ini ?>">
            <button type="submit" class="btn custom-btn">Tampilkan Data</button>
        </form>
    </div>
</div>

<!-- Tabel data presensi -->
<table class="table table-responsive">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Status</th>
            <th>Kegiatan</th>
            <th>Detail</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Urutkan data dari terbaru
        usort($data_presensi, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });
        // Nomor urut
        $nomor = 0;
        foreach ($data_presensi as $k => $v) {
            $nomor = $nomor + 1;
        ?>
        <tr>
            <td><?php echo $nomor ?></td>
            <td><?php echo $v['tanggal'] ?></td>
            <td><?php echo $v['Nama'] ?></td>
            <td><?php echo $v['jam_masuk'] ?></td>
            <td><?php echo $v['jam_keluar']?></td>
            <td><?php echo $v['status']; ?></td>
            <td class="custom-column"><?php echo $v['kegiatan']; ?></td>
            <td>
                <a href="<?= site_url('dashboardadmin/delete/' . $v['id_presensi']); ?>" 
                class="btn btn-danger" 
                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>
<!-- script buat word-break setelah 5 kata -->
<script>
    document.querySelectorAll('.custom-column').forEach(cell => {
        let words = cell.innerText.split(' ');
        for (let i = 5; i < words.length; i += 6) {
            words[i] = '<br>' + words[i];
        }
        cell.innerHTML = words.join(' ');
    });
</script>
<?= $this->endSection() ?>
