<?php
// File: src/config.php

// --- PENGATURAN KONEKSI DATABASE ---
// Ganti nilai di bawah ini sesuai dengan konfigurasi server database Anda.
define('DB_HOST', 'localhost');      // Host database, biasanya 'localhost'
define('DB_USER', 'root');           // Username database Anda (default XAMPP adalah 'root')
define('DB_PASS', '');               // Password database Anda (default XAMPP adalah kosong)
define('DB_NAME', 'db_pro_stroke');  // Nama database yang telah Anda buat

// --- PENGATURAN APLIKASI ---
// URL dasar aplikasi Anda. PENTING: Sesuaikan jika Anda meletakkan proyek di folder lain.
define('APP_URL', 'http://localhost/sistem-pakar-pro/public');

// Path root untuk folder 'src'. Digunakan untuk mempermudah pemanggilan file.
define('APP_ROOT', dirname(__DIR__)); // Ini akan otomatis menunjuk ke folder 'sistem-pakar-pro/'
