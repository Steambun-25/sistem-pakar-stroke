<?php
// File: src/views/app/diagnosa.php

// Memuat header dan judul halaman
view('layouts/header', ['title' => 'Mulai Diagnosa']); 
?>

<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="color: #00796B; font-weight: bold;">INPUT DATA & GEJALA</h2>
</div>

<!-- Menampilkan pesan error jika ada (misal: tidak ada gejala yang dipilih) -->
<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red; text-align: center; background: #ffebee; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<!-- Formulir ini akan mengirim data ke rute 'proses-diagnosa' menggunakan metode POST -->
<form action="<?= url('proses-diagnosa') ?>" method="POST">
    
    <h3>Data Pasien</h3>
    <div class="form-group">
        <label for="pasien_nama">Nama Pasien:</label>
        <input type="text" id="pasien_nama" name="pasien_nama" required>
    </div>
    <div class="form-group">
        <label for="pasien_umur">Umur Pasien:</label>
        <input type="number" id="pasien_umur" name="pasien_umur" required>
    </div>
    
    <h3 style="margin-top: 30px;">Pilih Gejala yang Dialami</h3>
    <div class="checkbox-group">
        <?php 
        // Melakukan loop pada data gejala yang dikirim dari PageController
        // untuk membuat daftar checkbox secara dinamis.
        foreach ($gejala as $g): 
        ?>
            <label class="checkbox-label">
                <input type="checkbox" name="gejala[]" value="<?= $g['id'] ?>"> 
                <?= $g['id'] ?> - <?= htmlspecialchars($g['nama']) ?>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="btn-group" style="margin-top: 30px;">
        <a href="<?= url('dashboard') ?>" class="btn" style="background-color: #757575; text-align:center; text-decoration:none; line-height: 1.5;">Kembali</a>
        <button type="submit" class="btn" style="width: 65%;">Proses Diagnosa</button>
    </div>
</form>

<?php 
// Memuat footer
view('layouts/footer'); 
?>
