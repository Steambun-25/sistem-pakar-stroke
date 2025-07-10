<?php
// File: src/views/app/data_pasien.php (Baru)

view('layouts/header', ['title' => 'Data Pasien']); 
?>

<div style="text-align: center; margin-bottom: 20px;">
    <h2 style="color: #00796B; font-weight: bold;">LANGKAH 1: DATA PASIEN</h2>
</div>

<!-- Form ini akan mengirim data ke rute 'proses-data-pasien' -->
<form action="<?= url('proses-data-pasien') ?>" method="POST">
    <div class="form-group">
        <label>Nama :</label>
        <input type="text" name="pasien_nama" required>
    </div>
    <div class="form-group">
        <label>Umur :</label>
        <input type="number" name="pasien_umur" required>
    </div>
    <div class="form-group">
        <label>Jenis Kelamin:</label>
        <div style="display: flex; align-items: center; margin-top: 10px;">
            <input type="radio" id="pasien-pria" name="gender" value="Pria" checked>
            <label for="pasien-pria" style="margin-left: 5px; margin-right: 20px;">Pria</label>
            <input type="radio" id="pasien-wanita" name="gender" value="Wanita">
            <label for="pasien-wanita" style="margin-left: 5px;">Wanita</label>
        </div>
    </div>
    <div class="form-group">
        <label>Alamat:</label>
        <textarea name="pasien_alamat" style="height: 80px;"></textarea>
    </div>
    <div class="btn-group" style="margin-top: 30px;">
        <a href="<?= url('dashboard') ?>" class="btn" style="background-color: #757575; text-align:center; text-decoration:none; line-height: 1.5;">Batal</a>
        <button type="submit" class="btn" style="width: 65%;">Lanjut ke Pilih Gejala</button>
    </div>
</form>

<?php 
view('layouts/footer'); 
?>
