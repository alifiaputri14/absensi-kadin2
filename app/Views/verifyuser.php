<?= $this->extend('/Layouts/admin_layout') ?>
<?= $this->section('customStyles') ?>
<link rel="stylesheet" href="/css/verifikasi.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- kartu judul -->
<div class="card title-card">
    <div class="card-body">
        <h3 class="card-title bold-text">Verifikasi Absensi</h3>
        <p><em><?= $tanggal_hari_ini ?></em></p>
    </div>
</div>

<!-- Tabel data presensi -->
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jam Masuk</th>
                <th>Status Kehadiran</th>
                <th>Foto</th>
                <th>Status Verifikasi</th>
                <th>Update</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($data_presensi)): ?>
            <tr>
                <td colspan="7" style="text-align: center;">Semua Data Telah Diverifikasi</td>
            </tr>
        <?php else: ?>
            <?php
            // Urutkan data dari terbaru
            usort($data_presensi, function($a, $b) {
                return strtotime($b['tanggal']) - strtotime($a['tanggal']);
            });
            // Nomor urut
            $nomor = 0;
            foreach ($data_presensi as $k => $v) {
                $nomor++;
            ?>
            <tr>
                <td><?php echo $nomor; ?></td>
                <td><?php echo $v['Nama']; ?></td>
                <td><?php echo $v['jam_masuk']; ?></td>
                <td><?php echo $v['status']; ?></td>
                <td>
                    <?php $imagePath = base_url('/uploads/photos/' . $v['foto']); ?>
                    <div class="img-container">
                        <?php if ($v['foto']): ?>
                            <img src="<?= $imagePath; ?>" alt="Foto <?php echo $v['status']; ?>" style="max-width: 300px; max-height: 400px; width: auto; height: auto;">
                        <?php else: ?>
                            <p class="no-photo-text">Tidak Ada Foto</p>
                        <?php endif; ?>
                    </div>
                </td>
                <td>
                        <?php if ($v['verifikasi'] == 'Pending'): ?>
                            <span style="color:white; background-color:orange; padding: 5px 15px; border-radius: 50px;">
                                <?php echo $v['verifikasi']; ?>
                            </span>
                        <?php else: ?>
                            <span style="color:white; background-color:green; padding: 5px 15px; border-radius: 50px;">
                                <?php echo $v['verifikasi']; ?>
                            </span>
                        <?php endif; ?>
                    </td>
<td>
    <div class="button-container">
        <a href="<?= site_url('verifyuser/updateVerifikasi/' . $v['id_presensi'] . '/Hadir'); ?>" 
           class="btn custom-btn btn-hadir" 
           onclick="return confirm('Apakah Anda yakin ingin mengupdate status menjadi Hadir?');">
           Hadir
        </a>
    </div>
    <div class="button-container">
        <a href="<?= site_url('verifyuser/updateVerifikasi/' . $v['id_presensi'] . '/Izin'); ?>" 
           class="btn custom-btn btn-izin" 
           onclick="return confirm('Apakah Anda yakin ingin mengupdate status menjadi Izin?');">
           Izin
        </a>
    </div>
    <div class="button-container">
        <a href="<?= site_url('verifyuser/updateVerifikasi/' . $v['id_presensi'] . '/Sakit'); ?>" 
           class="btn custom-btn btn-sakit" 
           onclick="return confirm('Apakah Anda yakin ingin mengupdate status menjadi Sakit?');">
           Sakit
        </a>
    </div>
    <div class="button-container">
        <a href="<?= site_url('verifyuser/updateVerifikasi/' . $v['id_presensi'] . '/Alpha'); ?>" 
           class="btn custom-btn btn-alpha" 
           onclick="return confirm('Apakah Anda yakin ingin mengupdate status menjadi Alpha?');">
           Alpha
        </a>
    </div>
</td>


                </tr>
            <?php } ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="row">
    <div class="col-12 col-md-6">
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="<?= site_url('verifyuser?page=' . ($currentPage - 1)) ?>">Sebelumnya</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="<?= site_url('verifyuser?page=' . $i) ?>" class="<?= $i == $currentPage ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($currentPage < $totalPages): ?>
                <a href="<?= site_url('verifyuser?page=' . ($currentPage + 1)) ?>">Selanjutnya</a>
            <?php endif; ?>
        </div>
    </div>
</div>

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