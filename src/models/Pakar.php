<?php
// File: src/models/Pakar.php (Lengkap & Final)

class Pakar {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Mengambil semua data gejala dari database.
     * @return array Daftar semua gejala.
     */
    public function getAllGejala(): array {
        $result = $this->db->query("SELECT * FROM gejala ORDER BY id");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }
    
    /**
     * Mengambil semua data kerusakan dari database.
     * @return array Daftar semua kerusakan.
     */
    public function getAllKerusakan(): array {
        $result = $this->db->query("SELECT * FROM kerusakan ORDER BY id");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Mengambil semua data solusi dari database.
     * @return array Daftar semua solusi.
     */
    public function getAllSolusi(): array {
        $result = $this->db->query("SELECT * FROM solusi ORDER BY id");
        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    /**
     * Mengambil semua data aturan beserta relasinya.
     * @return array Daftar semua aturan.
     */
    public function getAllAturan(): array {
        $result_aturan = $this->db->query("SELECT a.*, k.nama as kerusakan_nama FROM aturan a JOIN kerusakan k ON a.kerusakan_id = k.id ORDER BY a.id");
        if (!$result_aturan) return [];

        $aturan = $result_aturan->fetch_all(MYSQLI_ASSOC);

        foreach ($aturan as &$rule) {
            $gejala_res = $this->db->query("SELECT gejala_id FROM aturan_gejala WHERE aturan_id = '{$rule['id']}'");
            $rule['gejalaTerkait'] = $gejala_res ? array_column($gejala_res->fetch_all(MYSQLI_ASSOC), 'gejala_id') : [];
            
            $solusi_res = $this->db->query("SELECT solusi_id FROM aturan_solusi WHERE aturan_id = '{$rule['id']}'");
            $rule['solusiId'] = $solusi_res ? array_column($solusi_res->fetch_all(MYSQLI_ASSOC), 'solusi_id') : [];
        }
        return $aturan;
    }

    /**
     * Memproses diagnosa berdasarkan gejala yang dipilih.
     * @param array $selectedGejala Array berisi ID gejala yang dipilih pengguna.
     * @return array Hasil diagnosa.
     */
    public function diagnose(array $selectedGejala): array {
        if (empty($selectedGejala)) {
            return [];
        }
        
        $placeholders = implode(',', array_fill(0, count($selectedGejala), '?'));
        $types = str_repeat('s', count($selectedGejala));

        $stmt = $this->db->prepare("
            SELECT r.id as aturan_id, k.nama as kerusakan_nama, 
                   (SELECT COUNT(*) FROM aturan_gejala WHERE aturan_id = r.id) as total_gejala_aturan
            FROM aturan r
            JOIN kerusakan k ON r.kerusakan_id = k.id
            WHERE r.id IN (SELECT DISTINCT aturan_id FROM aturan_gejala WHERE gejala_id IN ($placeholders))
        ");
        $stmt->bind_param($types, ...$selectedGejala);
        $stmt->execute();
        $rules = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $results = [];
        foreach ($rules as $rule) {
            $stmt_match = $this->db->prepare("SELECT COUNT(*) as matched_count FROM aturan_gejala WHERE aturan_id = ? AND gejala_id IN ($placeholders)");
            $stmt_match->bind_param("i" . $types, $rule['aturan_id'], ...$selectedGejala);
            $stmt_match->execute();
            $matched_count = $stmt_match->get_result()->fetch_assoc()['matched_count'];
            
            $confidence = ($rule['total_gejala_aturan'] > 0) ? round(($matched_count / $rule['total_gejala_aturan']) * 100) : 0;
            
            $solusi_res = $this->db->query("
                SELECT s.nama FROM solusi s 
                JOIN aturan_solusi ars ON s.id = ars.solusi_id 
                WHERE ars.aturan_id = '{$rule['aturan_id']}'
            ");
            $solusi = $solusi_res ? array_column($solusi_res->fetch_all(MYSQLI_ASSOC), 'nama') : [];

            $results[] = [
                'kerusakan' => $rule['kerusakan_nama'],
                'persentase' => $confidence,
                'solusi' => array_unique($solusi)
            ];
        }
        return $results;
    }

    /**
     * Menyimpan atau memperbarui data sederhana (gejala, kerusakan, solusi).
     */
    public function saveData(string $table, string $id, string $nama, ?string $edit_id = null): bool {
        $target_id = $edit_id ?? $id;
        
        $stmt_check = $this->db->prepare("SELECT id FROM $table WHERE id = ?");
        $stmt_check->bind_param("s", $target_id);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0 && $edit_id) { // Update
            $stmt = $this->db->prepare("UPDATE $table SET id = ?, nama = ? WHERE id = ?");
            $stmt->bind_param("sss", $id, $nama, $edit_id);
        } else { // Insert
            $stmt = $this->db->prepare("INSERT INTO $table (id, nama) VALUES (?, ?)");
            $stmt->bind_param("ss", $id, $nama);
        }
        return $stmt->execute();
    }

    /**
     * Menghapus data sederhana.
     */
    public function deleteData(string $table, string $id): bool {
        $stmt = $this->db->prepare("DELETE FROM $table WHERE id = ?");
        $stmt->bind_param("s", $id);
        return $stmt->execute();
    }

    /**
     * Menyimpan atau memperbarui aturan.
     */
    public function saveAturan(string $id_text, string $kerusakanId, array $gejalaIds, array $solusiIds, ?int $edit_id = null): bool {
        $this->db->begin_transaction();
        try {
            $aturan_id = $edit_id;
            if ($edit_id) {
                $stmt = $this->db->prepare("UPDATE aturan SET id_text = ?, kerusakan_id = ? WHERE id = ?");
                $stmt->bind_param("ssi", $id_text, $kerusakanId, $edit_id);
                $stmt->execute();
                $this->db->query("DELETE FROM aturan_gejala WHERE aturan_id = $edit_id");
                $this->db->query("DELETE FROM aturan_solusi WHERE aturan_id = $edit_id");
            } else {
                $stmt = $this->db->prepare("INSERT INTO aturan (id_text, kerusakan_id) VALUES (?, ?)");
                $stmt->bind_param("ss", $id_text, $kerusakanId);
                $stmt->execute();
                $aturan_id = $this->db->insert_id;
            }

            if (!empty($gejalaIds)) {
                $stmt_gejala = $this->db->prepare("INSERT INTO aturan_gejala (aturan_id, gejala_id) VALUES (?, ?)");
                foreach ($gejalaIds as $gejala_id) {
                    $stmt_gejala->bind_param("is", $aturan_id, $gejala_id);
                    $stmt_gejala->execute();
                }
            }

            if (!empty($solusiIds)) {
                $stmt_solusi = $this->db->prepare("INSERT INTO aturan_solusi (aturan_id, solusi_id) VALUES (?, ?)");
                foreach ($solusiIds as $solusi_id) {
                    $stmt_solusi->bind_param("is", $aturan_id, $solusi_id);
                    $stmt_solusi->execute();
                }
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollback();
            return false;
        }
    }

    /**
     * Menghapus aturan.
     */
    public function deleteAturan(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM aturan WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
