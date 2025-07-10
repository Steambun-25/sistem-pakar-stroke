<?php
// File: src/helpers/functions.php

/**
 * Mengarahkan pengguna ke halaman lain.
 * @param string $path Rute tujuan (misal: 'login' atau 'dashboard').
 */
function redirect($path) {
    header("Location: " . url($path));
    exit();
}

/**
 * Memuat file view dan meneruskan data ke dalamnya.
 * @param string $viewName Nama file view (misal: 'auth/login').
 * @param array $data Data yang ingin diteruskan ke view.
 */
function view($viewName, $data = []) {
    // Mengekstrak array data menjadi variabel individual
    // Contoh: ['title' => 'Judul'] akan menjadi variabel $title
    extract($data);

    // Memuat file view dari folder 'views'
    require_once APP_ROOT . '/src/views/' . $viewName . '.php';
}

/**
 * Menghasilkan URL lengkap ke sebuah rute.
 * @param string $path Rute tujuan.
 * @return string URL lengkap.
 */
function url($path) {
    return APP_URL . '/' . trim($path, '/');
}

/**
 * Menghasilkan URL lengkap ke sebuah file aset (CSS, JS, gambar).
 * @param string $path Path ke file aset di dalam folder 'public/assets'.
 * @return string URL lengkap ke aset.
 */
function asset($path) {
    return APP_URL . '/assets/' . trim($path, '/');
}

/**
 * Memeriksa apakah pengguna sudah login atau belum.
 * @return bool True jika sudah login, false jika belum.
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
