<!-- File: src/views/admin/partials/crud_simple.php -->

<!-- Judul dinamis berdasarkan tipe data (Gejala, Kerusakan, atau Solusi) -->
<h4 style="margin-top: 2rem;">Daftar <?= $title ?></h4>

<!-- Tabel untuk menampilkan daftar data yang ada -->
<table class="management-table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama/Deskripsi</th>
            <th class="actions">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $item): ?>
        <tr>
            <td><?= $item['id'] ?></td>
            <td><?= htmlspecialchars($item['nama']) ?></td>
            <td class="actions">
                <!-- Tombol Edit memanggil fungsi JavaScript dengan parameter yang sesuai -->
                <button class="btn-edit" onclick="editItem('<?= $type ?>', '<?= $item['id'] ?>', '<?= htmlspecialchars(addslashes($item['nama'])) ?>')">Edit</button>
                
                <!-- Link Hapus mengarah ke rute yang benar dan meminta konfirmasi -->
                <a href="<?= url('admin/delete/'.$type.'/'.$item['id']) ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Formulir untuk menambah atau mengedit data -->
<div class="management-form">
    <h4 id="form-<?= $type ?>-title">Tambah <?= $title ?> Baru</h4>
    
    <!-- Action dari form ini juga dinamis berdasarkan tipe data -->
    <form id="form-<?= $type ?>" action="<?= url('admin/save/'.$type) ?>" method="POST">
        
        <!-- Input tersembunyi ini akan diisi oleh JavaScript saat mode edit -->
        <input type="hidden" name="edit_id">
        
        <div class="form-group">
            <label>Kode</label>
            <input type="text" name="id" id="<?= $type ?>-id-input" required>
        </div>
        <div class="form-group">
            <label>Nama/Deskripsi</label>
            <input type="text" name="nama" id="<?= $type ?>-nama-input" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
