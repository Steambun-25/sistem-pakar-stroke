<?php
// File: src/controllers/PageController.php (Lengkap & Final)

class PageController {

    /**
     * Constructor that runs for every method in this class.
     * It ensures that only a logged-in user can access these pages.
     */
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('login');
        }
    }

    /**
     * Displays the main dashboard.
     * It also cleans up any old diagnosis data from the session
     * to ensure a fresh start for a new diagnosis process.
     */
    public function dashboard() {
        unset($_SESSION['pasien_data']);
        unset($_SESSION['hasil_diagnosa']);
        view('app/dashboard');
    }

    /**
     * Displays the patient data form. This is the first step of the diagnosis.
     */
    public function dataPasien() {
        view('app/data_pasien');
    }

    /**
     * Processes the data from the patient form.
     * It saves the patient data into the session and redirects to the next step.
     */
    public function prosesDataPasien() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Save patient data into the session to carry it to the next step
            $_SESSION['pasien_data'] = [
                'nama' => $_POST['pasien_nama'] ?? 'Tanpa Nama',
                'umur' => $_POST['pasien_umur'] ?? 'N/A',
                'gender' => $_POST['gender'] ?? 'N/A',
                'alamat' => $_POST['pasien_alamat'] ?? 'N/A'
            ];
            // Redirect to the symptom selection page
            redirect('input-gejala');
        } else {
            // If accessed directly, redirect back to the form
            redirect('data-pasien');
        }
    }

    /**
     * Displays the symptom selection page.
     * It checks if patient data exists in the session to prevent skipping steps.
     */
    public function inputGejala() {
        // Ensure patient data has been filled before accessing this page
        if (!isset($_SESSION['pasien_data'])) {
            redirect('data-pasien');
        }

        $db = (new Database())->getConnection();
        $pakarModel = new Pakar($db);
        $gejala = $pakarModel->getAllGejala();
        
        // Pass the symptom data to the view
        view('app/input_gejala', ['gejala' => $gejala]);
    }
    
    /**
     * Processes the selected symptoms to generate a diagnosis.
     */
    public function prosesDiagnosa() {
        // This process only runs if the method is POST AND patient data exists in the session.
        // This is the key to fixing the redirect issue.
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['pasien_data'])) {
            $selectedGejala = $_POST['gejala'] ?? [];
            
            // Validate that at least one symptom is selected
            if (empty($selectedGejala)) {
                $_SESSION['error'] = 'Anda harus memilih setidaknya satu gejala.';
                redirect('input-gejala');
            }

            $db = (new Database())->getConnection();
            $pakarModel = new Pakar($db);
            $hasil = $pakarModel->diagnose($selectedGejala);

            // Save the diagnosis result to the session to be displayed on the result page
            $_SESSION['hasil_diagnosa'] = $hasil;

            redirect('hasil');
        } else {
            // If conditions are not met, redirect to the dashboard as a safe fallback.
            redirect('dashboard');
        }
    }

    /**
     * Displays the final diagnosis result page.
     */
    public function hasil() {
        // Retrieve diagnosis result and patient data from the session
        $hasil = $_SESSION['hasil_diagnosa'] ?? null;
        $pasien = $_SESSION['pasien_data'] ?? null;

        // If for any reason the data is missing (e.g., page refresh), redirect to dashboard
        if ($hasil === null || $pasien === null) {
            redirect('dashboard');
        }

        // Clear the diagnosis result from the session after displaying it
        // to prevent old results from showing up again.
        unset($_SESSION['hasil_diagnosa']);
        
        view('app/hasil', ['hasil' => $hasil, 'pasien' => $pasien]);
    }
}
