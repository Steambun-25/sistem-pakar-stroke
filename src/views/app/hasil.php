<?php
// File: src/views/app/hasil.php (Hasil Digabung)

// Memuat header
view('layouts/header', ['title' => 'Hasil Diagnosa']); 

// Blok PHP ini untuk memproses data sebelum ditampilkan
// Kita akan mengumpulkan semua solusi menjadi satu dan menghapus duplikat
$semua_solusi = [];
if (!empty($hasil)) {
    foreach ($hasil as $item) {
        foreach ($item['solusi'] as $solusi_item) {
            $semua_solusi[] = $solusi_item;
        }
    }
}
$solusi_unik = array_unique($semua_solusi);
?>

<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="color: #00796B; font-weight: bold;">HASIL DIAGNOSA</h2>
</div>

<!-- Menampilkan data pasien -->
<div class="hasil-container">
    <div class="hasil-row">
        <div class="hasil-label">Nama Pasien</div>
        <div class="hasil-value">: <?= htmlspecialchars($pasien['nama']) ?></div>
    </div>
    <div class="hasil-row">
        <div class="hasil-label">Umur</div>
        <div class="hasil-value">: <?= htmlspecialchars($pasien['umur']) ?></div>
    </div>
    <div class="hasil-row">
        <div class="hasil-label">Jenis Kelamin</div>
        <div class="hasil-value">: <?= htmlspecialchars($pasien['gender']) ?></div>
    </div>
</div>

<!-- Memeriksa apakah ada hasil diagnosa -->
<?php if (empty($hasil)): ?>
    <div class="hasil-diagnosa">
        <p>Tidak ada potensi kerusakan yang terdeteksi berdasarkan gejala yang dipilih.</p>
    </div>
<?php else: ?>
    <!-- Blok untuk menampilkan SEMUA potensi kerusakan -->
    <div class="hasil-diagnosa">
        <div><strong>Potensi Kerusakan:</strong></div>
        <ul style="margin-top: 5px; padding-left: 20px; list-style-type: '- ';">
            <?php foreach ($hasil as $item): ?>
                <li><?= htmlspecialchars($item['kerusakan']) ?> (kemungkinan : <strong><?= $item['persentase'] ?>%</strong>)</li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Blok untuk menampilkan SEMUA saran solusi yang unik -->
    <div class="hasil-diagnosa">
        <div><strong>Saran Solusi:</strong></div>
        <ul style="margin-top: 5px; padding-left: 20px; list-style-type: '- ';">
            <?php foreach ($solusi_unik as $solusi): ?>
                <li><?= htmlspecialchars($solusi) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="btn-group" style="margin-top: 30px;">
    <button class="btn" onclick="window.print()">CETAK</button>
    <a href="<?= url('dashboard') ?>" class="btn" style="text-align:center; text-decoration:none; line-height: 1.5;">Selesai</a>
</div>

<?php 
// Memuat footer
view('layouts/footer'); 
?>
