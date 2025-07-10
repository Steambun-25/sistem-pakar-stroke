<?php
// File: src/views/app/input_gejala.php (Baru)

view('layouts/header', ['title' => 'Input Gejala']); 
?>

<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="color: #00796B; font-weight: bold;">LANGKAH 2: PILIH GEJALA</h2>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red; text-align: center; background: #ffebee; padding: 10px; border-radius: 4px; margin-bottom: 15px;">
        <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </p>
<?php endif; ?>

<!-- Form ini akan mengirim data ke rute 'proses-diagnosa' -->
<form action="<?= url('proses-diagnosa') ?>" method="POST">
    <div class="checkbox-group">
        <?php foreach ($gejala as $g): ?>
            <label class="checkbox-label">
                <input type="checkbox" name="gejala[]" value="<?= $g['id'] ?>"> 
                <?= $g['id'] ?> - <?= htmlspecialchars($g['nama']) ?>
            </label>
        <?php endforeach; ?>
    </div>

    <div class="btn-group" style="margin-top: 30px;">
        <a href="<?= url('data-pasien') ?>" class="btn" style="background-color: #757575; text-align:center; text-decoration:none; line-height: 1.5;">Kembali</a>
        <button type="submit" class="btn" style="width: 65%;">Proses Diagnosa</button>
    </div>
</form>

<?php 
view('layouts/footer'); 
?>
