<?php
// File: src/views/app/dashboard.php (Lengkap & Final)

// Memuat file header, yang akan menampilkan navigasi utama.
view('layouts/header', ['title' => 'Dashboard']); 

// Mengecek apakah pengguna yang login adalah admin untuk menyesuaikan tampilan.
$isAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>

<main>
    <!-- 
        Struktur wrapper yang benar: 
        .app-wrapper untuk padding dan latar belakang.
        .main-container untuk mengatur lebar konten di tengah.
    -->
    <div class="app-wrapper">
        <div class="main-container">
        
            <!-- Bagian Header Sambutan -->
            <div class="dashboard-header">
                <h2>Selamat Datang, <?= htmlspecialchars($_SESSION['user_nama']) ?>!</h2>
                <p>
                    <?php if ($isAdmin): ?>
                        Anda login sebagai **Admin**. Anda dapat memulai diagnosa baru atau mengelola data inti sistem.
                    <?php else: ?>
                        Siap untuk memulai diagnosa? Klik kartu di bawah ini untuk memulai proses deteksi dini potensi stroke.
                    <?php endif; ?>
                </p>
            </div>

            <!-- Bagian Grid Menu Aksi -->
            <!-- Kelas 'admin-view' akan ditambahkan jika admin login, membuat layout menjadi 2 kolom -->
            <div class="dashboard-grid <?= $isAdmin ? 'admin-view' : '' ?>">
                
                <!-- Kartu untuk Mulai Diagnosa (Selalu tampil untuk semua role) -->
                <a href="<?= url('data-pasien') ?>" class="action-card">
                    <div class="icon">🩺</div>
                    <h3>Mulai Diagnosa Baru</h3>
                    <p>Isi data pasien dan pilih gejala untuk melihat potensi risiko stroke berdasarkan basis pengetahuan kami.</p>
                </a>

                <!-- Kartu untuk Manajemen Data (Hanya tampil untuk Admin) -->
                <?php if ($isAdmin): ?>
                    <a href="<?= url('admin') ?>" class="action-card">
                        <div class="icon">⚙️</div>
                        <h3>Manajemen Data</h3>
                        <p>Kelola data gejala, kerusakan, solusi, dan aturan yang menjadi dasar dari sistem pakar ini.</p>
                    </a>
                <?php endif; ?>

            </div>

        </div>
    </div>
</main>

<?php 
// Memuat file footer untuk menutup halaman.
view('layouts/footer'); 
?>
