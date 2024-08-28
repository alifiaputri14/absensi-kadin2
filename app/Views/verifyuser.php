<?= $this->extend('/layouts/admin_layout') ?>
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
<table class="table table-responsive">
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
        <?php
        // Urutkan data dari terbaru
        usort($data_presensi, function ($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        // Nomor urut
        $nomor = 0;
        foreach ($data_presensi as $k => $v) {
            $nomor++;
        ?>
            <tr>
                <td style="text-align: center;"><?php echo $nomor; ?></td>
                <td style="text-align: center;"><?php echo $v['Nama']; ?></td>
                <td style="text-align: center;"><?php echo $v['jam_masuk']; ?></td>
                <td style="text-align: center;"><?php echo $v['status']; ?></td>

                <td>
                    <?php if (!empty($v['foto'])): ?>
                        <?php $imagePath = base_url('/uploads/photos/' . $v['foto']); ?>
                        <img src="<?= $imagePath ?>" alt="Foto" style="max-width: 300px; max-height: 400px;">
                    <?php else: ?>
                        <p>Gambar tidak tersedia.</p>
                    <?php endif; ?>
                </td>

                <td style="text-align: center;">
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
                    <?php if ($v['verifikasi'] == 'Pending'): ?>
                                        <a href="<?= site_url('verifyuser/updateVerifikasi/' . $v['id_presensi']); ?>" 
                                        class="btn custom-btn" 
                                        onclick="return confirm('Apakah Anda yakin ingin mengupdate status verifikasi ?');">
                                        Update
                                        </a>
                                    <?php else: ?>
                                        <button class="btn custom-btn" disabled>Update</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

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