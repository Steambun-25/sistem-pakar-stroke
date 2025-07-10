<?php
// File: src/models/User.php

class User {
    private $db;

    /**
     * Constructor untuk menginisialisasi koneksi database.
     */
    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Mencari pengguna berdasarkan alamat email.
     * @param string $email Email pengguna.
     * @return array|null Data pengguna jika ditemukan, atau null jika tidak.
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /**
     * Membuat pengguna baru di database.
     * @param string $nama Nama lengkap pengguna.
     * @param string $email Email pengguna.
     * @param string $password Password pengguna (belum di-hash).
     * @return bool True jika berhasil, false jika gagal.
     */
    public function create($nama, $email, $password) {
        // Meng-hash password untuk keamanan sebelum disimpan
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->db->prepare("INSERT INTO users (nama, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nama, $email, $hashed_password);
        
        return $stmt->execute();
    }
}
