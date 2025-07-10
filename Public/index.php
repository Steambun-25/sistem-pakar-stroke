<?php
// File: public/index.php (Diperbarui dengan Rute Home)

require_once '../src/init.php';

// ... (Kode router dinamis tetap sama) ...
$request_uri = $_SERVER['REQUEST_URI'];
$script_path = dirname($_SERVER['SCRIPT_NAME']);
$base_path = str_replace('\\', '/', $script_path);
if ($base_path != '/' && strpos($request_uri, $base_path) === 0) {
    $path = substr($request_uri, strlen($base_path));
} else {
    $path = $request_uri;
}
$path = explode('?', $path, 2)[0];
$route = trim($path, '/');
$route = $route ?: 'home';

$routeParts = explode('/', $route);
$mainRoute = $routeParts[0];

switch ($mainRoute) {
    // --- RUTE BARU UNTUK HALAMAN AWAL ---
    case 'home':
        (new HomeController())->index();
        break;

    // ... (Rute lainnya tetap sama) ...
    case 'login': (new AuthController())->login(); break;
    case 'register': (new AuthController())->register(); break;
    case 'logout': (new AuthController())->logout(); break;
    case 'dashboard': (new PageController())->dashboard(); break;
    case 'data-pasien': (new PageController())->dataPasien(); break;
    case 'proses-data-pasien': (new PageController())->prosesDataPasien(); break;
    case 'input-gejala': (new PageController())->inputGejala(); break;
    case 'proses-diagnosa': (new PageController())->prosesDiagnosa(); break;
    case 'hasil': (new PageController())->hasil(); break;
    case 'admin':
        // ... (logika admin tetap sama) ...
        break;

    default:
        http_response_code(404);
        echo "<h1>404 - Halaman Tidak Ditemukan</h1>";
        break;
}
