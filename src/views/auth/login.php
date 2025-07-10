<?php
// File: src/views/auth/login.php (Layout Diperbaiki)

view('layouts/header', ['title' => 'Login']); 
?>

<main>
    <!-- PERUBAHAN: Menggunakan kelas "auth-wrapper" yang benar -->
    <div class="auth-wrapper">
        <div class="auth-layout">
            
            <!-- Kolom Kiri: Formulir -->
            <div class="auth-form-section">
                <div class="form-container">
                    <h2>Selamat Datang Kembali</h2>
                    
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>

                    <form action="<?= url('login') ?>" method="POST">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" placeholder="masukkan@email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" placeholder="********" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" style="width: 100%;">LOGIN</button>
                        </div>
                    </form>
                    
                    <p style="text-align: center; margin-top: 2rem; font-size: 0.9rem;">
                        Belum punya akun? <a href="<?= url('register') ?>" style="color: var(--primary-color); text-decoration: none; font-weight: 600;">Daftar di sini</a>
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
