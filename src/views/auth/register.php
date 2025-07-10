<?php
// File: src/views/auth/register.php (Layout Diperbaiki)

view('layouts/header', ['title' => 'Daftar Akun Baru']); 
?>

<main>
    <!-- PERUBAHAN: Menggunakan kelas "auth-wrapper" yang benar -->
    <div class="auth-wrapper">
        <div class="auth-layout">

            <!-- Kolom Kiri: Formulir -->
            <div class="auth-form-section">
                <div class="form-container">
                    <h2>Buat Akun Baru</h2>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <form action="<?= url('register') ?>" method="POST">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">DAFTAR</button>
                        </div>
                    </form>
                    
                    <p style="text-align: center; margin-top: 2rem; font-size: 0.9rem;">
                        Sudah punya akun? <a href="<?= url('login') ?>" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Login di sini</a>
                    </p>
                </div>
            </div>

            <!-- Kolom Kanan: Gambar Ilustrasi -->
            <div class="auth-image-section">
                <img src="<?= asset('images/ilustrasi-jantung.png') ?>" alt="Ilustrasi Jantung">
            </div>
            
        </div>
    </div>
</main>

<?php 
view('layouts/footer'); 
?>
