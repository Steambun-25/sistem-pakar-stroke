<?php
// File: src/controllers/HomeController.php (Baru)

class HomeController {
    /**
     * Menampilkan halaman awal (landing page).
     */
    public function index() {
        // Jika pengguna sudah login, langsung arahkan ke dashboard.
        if (isLoggedIn()) {
            redirect('dashboard');
        }
        // Jika belum, tampilkan halaman awal.
        view('home');
    }
}
