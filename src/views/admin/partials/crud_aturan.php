<!-- File: src/views/admin/partials/crud_aturan.php -->
<h4 style="margin-top: 2rem;">Daftar Aturan (Rules)</h4>

<!-- Tabel untuk menampilkan daftar aturan yang ada -->
<table class="management-table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Deskripsi Aturan</th>
            <th class="actions">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($aturan as $item): ?>
        <tr>
            <td><?= $item['id_text'] ?></td>
            <td>JIKA (<?= implode(', ', $item['gejalaTerkait']) ?>) MAKA <?= htmlspecialchars($item['kerusakan_nama']) ?></td>
            <td class="actions">
                <!-- Tombol Edit memanggil fungsi JavaScript dengan semua data yang diperlukan -->
                <button class="btn-edit" onclick="editAturan('<?= $item['id'] ?>', '<?= $item['id_text'] ?>', '<?= $item['kerusakan_id'] ?>', '<?= htmlspecialchars(json_encode($item['gejalaTerkait']), ENT_QUOTES, 'UTF-8') ?>', '<?= htmlspecialchars(json_encode($item['solusiId']), ENT_QUOTES, 'UTF-8') ?>')">Edit</button>
                
                <!-- Link Hapus mengarah ke rute yang benar dan meminta konfirmasi -->
                <a href="<?= url('admin/delete-aturan/'.$item['id']) ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus aturan <?= $item['id_text'] ?>?')">Hapus</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Formulir untuk menambah atau mengedit aturan -->
<div class="management-form">
    <h4 id="form-aturan-title">Tambah Aturan Baru</h4>
    
    <!-- Action dari form ini mengarah ke rute 'save-aturan' -->
    <form id="form-aturan" action="<?= url('admin/save-aturan') ?>" method="POST">
        
        <!-- Input tersembunyi ini akan diisi oleh JavaScript saat mode edit -->
        <input type="hidden" id="aturan-edit-id" name="edit_id">
        
        <div class="form-group">
            <label>Kode Aturan (mis: R06)</label>
            <input type="text" id="aturan-id-text-input" name="id_text" required>
        </div>
        <div class="form-group">
            <label>MAKA Potensi Kerusakan:</label>
            <select name="kerusakan_id" id="aturan-kerusakan-select" required>
                <option value="" disabled selected>-- Pilih Kerusakan --</option>
                <?php foreach($kerusakan as $k): ?>
                    <option value="<?= $k['id'] ?>"><?= $k['id'] ?> - <?= htmlspecialchars($k['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>JIKA Mengalami Gejala (pilih satu atau lebih):</label>
            <div class="checkbox-group" id="aturan-gejala-checkbox-container">
                <?php foreach($gejala as $g): ?>
                    <label class="checkbox-label">
                        <input type="checkbox" name="gejala[]" value="<?= $g['id'] ?>"> 
                        <?= $g['id'] ?> - <?= htmlspecialchars($g['nama']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="form-group">
            <label>DAN Solusinya Adalah (pilih satu atau lebih):</label>
            <div class="checkbox-group" id="aturan-solusi-checkbox-container">
                <?php foreach($solusi as $s): ?>
                    <label class="checkbox-label">
                        <input type="checkbox" name="solusi[]" value="<?= $s['id'] ?>"> 
                        <?= $s['id'] ?> - <?= htmlspecialchars($s['nama']) ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Aturan</button>
        <button type="button" class="btn" onclick="resetFormAturan()" style="background-color: #757575;">Batal</button>
    </form>
</div>
