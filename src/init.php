<?php
// File: src/init.php (Dengan Error Display)

// --- BAGIAN DEBUGGING ---
// Baris ini akan memaksa PHP menampilkan error apa pun ke layar.
// Ini sangat membantu untuk menemukan masalah.
// Setelah aplikasi selesai, baris ini bisa dihapus atau diberi komentar.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// -----------------------

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Jakarta');
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/helpers/functions.php';

spl_autoload_register(function ($className) {
    $paths = [
        APP_ROOT . '/src/models/' . $className . '.php',
        APP_ROOT . '/src/controllers/' . $className . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
        }
    }
});

class Database {
    private $connection = null;
    public function getConnection() {
        if ($this->connection === null) {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($this->connection->connect_error) {
                die("Koneksi database gagal: " . $this->connection->connect_error);
            }
        }
        return $this->connection;
    }
}
