<?php
// File: src/controllers/AdminController.php

class AdminController {
    
    private $db;
    private $pakarModel;

    public function __construct() {
        // Keamanan: Pastikan hanya admin yang bisa mengakses
        if (!isLoggedIn() || $_SESSION['user_role'] !== 'admin') { 
            $_SESSION['error'] = 'Anda tidak memiliki hak akses untuk halaman ini.';
            redirect('dashboard');
        }
        
        $this->db = (new Database())->getConnection();
        $this->pakarModel = new Pakar($this->db);
    }

    /**
     * Menampilkan halaman manajemen utama dengan semua data.
     */
    public function index() {
        $data = [
            'gejala' => $this->pakarModel->getAllGejala(),
            'kerusakan' => $this->pakarModel->getAllKerusakan(),
            'solusi' => $this->pakarModel->getAllSolusi(),
            'aturan' => $this->pakarModel->getAllAturan(),
        ];
        view('admin/manajemen', $data);
    }

    /**
     * Menyimpan data sederhana (gejala, kerusakan, solusi).
     */
    public function saveData($type) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $nama = $_POST['nama'] ?? '';
            $edit_id = $_POST['edit_id'] ?? null;
            
            if (empty($id) || empty($nama)) {
                $_SESSION['error'] = 'Kode dan Nama tidak boleh kosong.';
            } elseif ($this->pakarModel->saveData($type, $id, $nama, $edit_id)) {
                $_SESSION['success'] = "Data $type berhasil disimpan.";
            } else {
                $_SESSION['error'] = "Gagal menyimpan data $type. Kode mungkin sudah ada.";
            }
            redirect('admin');
        }
    }

    /**
     * Menghapus data sederhana.
     */
    public function deleteData($type, $id) {
        if ($this->pakarModel->deleteData($type, $id)) {
            $_SESSION['success'] = "Data $type berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Gagal menghapus data $type.";
        }
        redirect('admin');
    }

    /**
     * Menyimpan atau memperbarui aturan.
     */
    public function saveAturan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_text = $_POST['id_text'] ?? '';
            $kerusakanId = $_POST['kerusakan_id'] ?? '';
            $gejalaIds = $_POST['gejala'] ?? [];
            $solusiIds = $_POST['solusi'] ?? [];
            $edit_id = $_POST['edit_id'] ?? null;

            if (empty($id_text) || empty($kerusakanId) || empty($gejalaIds) || empty($solusiIds)) {
                $_SESSION['error'] = 'Semua field pada form aturan wajib diisi.';
            } elseif ($this->pakarModel->saveAturan($id_text, $kerusakanId, $gejalaIds, $solusiIds, $edit_id)) {
                $_SESSION['success'] = "Aturan berhasil disimpan.";
            } else {
                $_SESSION['error'] = "Gagal menyimpan aturan.";
            }
            redirect('admin');
        }
    }

    /**
     * Menghapus aturan.
     */
    public function deleteAturan($id) {
        if ($this->pakarModel->deleteAturan($id)) {
            $_SESSION['success'] = "Aturan berhasil dihapus.";
        } else {
            $_SESSION['error'] = "Gagal menghapus aturan.";
        }
        redirect('admin');
    }
}
