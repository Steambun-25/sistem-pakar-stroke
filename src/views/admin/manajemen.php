<?php
// File: src/views/admin/manajemen.php

// Memuat header
view('layouts/header', ['title' => 'Manajemen Data']); 
?>

<main class="page-wrapper">
    <div class="main-container">
        <div class="app-card">
            <div class="dashboard-header" style="margin-bottom: 2rem;">
                <h2>Manajemen Data Sistem Pakar</h2>
                <p>Kelola data inti yang menjadi dasar dari proses diagnosa.</p>
            </div>

            <!-- Navigasi Tab -->
            <div class="tabs-container">
                <div class="tab-link active" onclick="openTab(event, 'gejala')">Gejala</div>
                <div class="tab-link" onclick="openTab(event, 'kerusakan')">Kerusakan</div>
                <div class="tab-link" onclick="openTab(event, 'solusi')">Solusi</div>
                <div class="tab-link" onclick="openTab(event, 'aturan')">Aturan</div>
            </div>

            <!-- Tampilkan pesan sukses/error dari session -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error" style="margin-top: 1rem;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success" style="margin-top: 1rem;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
            <?php endif; ?>

            <!-- Konten Tab akan dimuat di sini dari file partials -->
            <div id="gejala" class="tab-content">
                <?php view('admin/partials/crud_simple', ['title' => 'Gejala', 'type' => 'gejala', 'data' => $gejala]); ?>
            </div>
            <div id="kerusakan" class="tab-content">
                <?php view('admin/partials/crud_simple', ['title' => 'Kerusakan', 'type' => 'kerusakan', 'data' => $kerusakan]); ?>
            </div>
            <div id="solusi" class="tab-content">
                <?php view('admin/partials/crud_simple', ['title' => 'Solusi', 'type' => 'solusi', 'data' => $solusi]); ?>
            </div>
            <div id="aturan" class="tab-content">
                <?php view('admin/partials/crud_aturan', ['aturan' => $aturan, 'gejala' => $gejala, 'kerusakan' => $kerusakan, 'solusi' => $solusi]); ?>
            </div>

            <a href="<?= url('dashboard') ?>" class="btn btn-secondary" style="margin-top: 2rem;">Kembali ke Dashboard</a>
        </div>
    </div>
</main>

<script>
function openTab(evt, tabName) {
    let i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tab-link");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

function editItem(type, id, nama) {
    document.getElementById(`form-${type}-title`).innerText = `Edit ${type.charAt(0).toUpperCase() + type.slice(1)} (${id})`;
    const form = document.getElementById(`form-${type}`);
    
    let editInput = form.querySelector('input[name="edit_id"]');
    if (!editInput) {
        editInput = document.createElement('input');
        editInput.type = 'hidden';
        editInput.name = 'edit_id';
        form.prepend(editInput);
    }
    editInput.value = id;
    
    document.getElementById(`${type}-id-input`).value = id;
    document.getElementById(`${type}-nama-input`).value = nama;
    // Kode tidak bisa diubah saat edit untuk menjaga konsistensi data
    document.getElementById(`${type}-id-input`).readOnly = true; 
    window.scrollTo({ top: document.getElementById(`form-${type}-title`).offsetTop, behavior: 'smooth' });
}

function editAturan(id, id_text, kerusakan_id, gejala_json, solusi_json) {
    const gejalaTerkait = JSON.parse(gejala_json);
    const solusiTerkait = JSON.parse(solusi_json);
    document.getElementById('form-aturan-title').innerText = `Edit Aturan ${id_text}`;
    document.getElementById('aturan-edit-id').value = id;
    document.getElementById('aturan-id-text-input').value = id_text;
    document.getElementById('aturan-id-text-input').readOnly = true;
    document.getElementById('aturan-kerusakan-select').value = kerusakan_id;
    document.querySelectorAll('#aturan-gejala-checkbox-container input').forEach(cb => cb.checked = gejalaTerkait.includes(cb.value));
    document.querySelectorAll('#aturan-solusi-checkbox-container input').forEach(cb => cb.checked = solusiTerkait.includes(cb.value));
    window.scrollTo({ top: document.getElementById('form-aturan-title').offsetTop, behavior: 'smooth' });
}

function resetFormAturan() {
    document.getElementById('form-aturan-title').innerText = 'Tambah Aturan Baru';
    document.getElementById('form-aturan').reset();
    document.getElementById('aturan-edit-id').value = '';
    document.getElementById('aturan-id-text-input').readOnly = false;
}

// Jalankan klik pada tab pertama secara default saat halaman dimuat
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.tab-link').click();
});
</script>

<?php view('layouts/footer'); ?>
