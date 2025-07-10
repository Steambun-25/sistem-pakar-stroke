<?php
// File: src/views/home.php (Final)

view('layouts/header', ['title' => 'Selamat Datang di StrokeCare']); 
?>

<main>
    <div class="main-container">
        <section class="hero-section">
            <div class="hero-content">
                <div class="hero-text">
                    <p class="greeting">Hallo, selamat datang di</p>
                    <h1>StrokeCare</h1>
                    <p class="tagline">Tempat dimana kamu bisa cek potensi kamu terkena stroke.</p>
                    <div class="btn-group">
                        <a href="<?= url('register') ?>" class="btn btn-primary">DAFTAR</a>
                        <a href="<?= url('login') ?>" class="btn btn-secondary">LOGIN</a>
                    </div>
                </div>
                <div class="hero-image">
                    <img src="<?= asset('images/ilustrasi-jantung.png') ?>" alt="Ilustrasi Jantung">
                </div>
            </div>
        </section>
    </div>
</main>

<?php 
view('layouts/footer'); 
?>
