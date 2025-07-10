<?php
// File: src/controllers/AuthController.php (Perbaikan Logout)

class AuthController {

    public function login() {
        if (isLoggedIn()) {
            redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = (new Database())->getConnection();
            $userModel = new User($db);
            
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $user = $userModel->findByEmail($email);
            
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_nama'] = $user['nama'];
                $_SESSION['user_role'] = $user['role'];
                redirect('dashboard');
            } else {
                $_SESSION['error'] = 'Email atau password salah.';
                redirect('login');
            }
        } else {
            view('auth/login');
        }
    }

    public function register() {
        if (isLoggedIn()) {
            redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $db = (new Database())->getConnection();
            $userModel = new User($db);
            
            $nama = $_POST['nama'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($nama) || empty($email) || empty($password)) {
                 $_SESSION['error'] = 'Semua field wajib diisi.';
                 redirect('register');
            }

            if ($userModel->findByEmail($email)) {
                $_SESSION['error'] = 'Email sudah terdaftar.';
                redirect('register');
            }

            if ($userModel->create($nama, $email, $password)) {
                $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
                redirect('login');
            } else {
                $_SESSION['error'] = 'Registrasi gagal, silakan coba lagi.';
                redirect('register');
            }
        } else {
            view('auth/register');
        }
    }

    /**
     * Menghancurkan session dan mengarahkan ke halaman login.
     */
    public function logout() {
        session_destroy();
        redirect('login');
    }
}

// Tag penutup PHP sengaja dihapus. Ini adalah praktik terbaik untuk file
// yang hanya berisi kode PHP untuk mencegah "output" yang tidak disengaja.
