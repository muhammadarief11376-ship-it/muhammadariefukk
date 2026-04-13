<?php
/**
 * Model Input Aspirasi
 */

require_once __DIR__ . '/Model.php';

class InputAspirasi extends Model {
    protected $table = 'input_aspirasi';
    protected $primaryKey = 'id_pelaporan';
    
    /**
     * Membuat aspirasi baru beserta status awal
     * @param array $data
     * @return int ID pelaporan yang baru dibuat
     */
    public function createWithStatus(array $data): int {
        // Insert input aspirasi
        $this->create($data);
        $idPelaporan = (int) $this->getLastInsertId();
        
        // Insert status awal di tabel aspirasi
        $sql = "INSERT INTO aspirasi (id_pelaporan, status) VALUES (?, 'Menunggu')";
        $this->db->query($sql, [$idPelaporan]);
        
        return $idPelaporan;
    }
    
    /**
     * Mendapatkan aspirasi dengan detail lengkap
     * @param int $id
     * @return array|false
     */
    public function getDetail(int $id) {
        $sql = "SELECT ia.*, s.nama as nama_siswa, s.kelas, k.ket_kategori,
                       a.id_aspirasi, a.status, a.feedback, a.tanggal_update
                FROM {$this->table} ia
                JOIN siswa s ON ia.nis = s.nis
                JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE ia.id_pelaporan = ?";
        return $this->db->query($sql, [$id])->fetch();
    }
    
    /**
     * Mendapatkan semua aspirasi dengan detail
     * @param array $filters Filter options (status, kategori, nis, tanggal_mulai, tanggal_akhir)
     * @return array
     */
    public function getAllWithDetail(array $filters = []): array {
        $sql = "SELECT ia.*, s.nama as nama_siswa, s.kelas, k.ket_kategori,
                       a.id_aspirasi, a.status, a.feedback, a.tanggal_update
                FROM {$this->table} ia
                JOIN siswa s ON ia.nis = s.nis
                JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE 1=1";
        
        $params = [];
        
        // Filter by status
        if (!empty($filters['status'])) {
            $sql .= " AND a.status = ?";
            $params[] = $filters['status'];
        }
        
        // Filter by kategori
        if (!empty($filters['kategori'])) {
            $sql .= " AND ia.id_kategori = ?";
            $params[] = $filters['kategori'];
        }
        
        // Filter by nis (untuk siswa)
        if (!empty($filters['nis'])) {
            $sql .= " AND ia.nis = ?";
            $params[] = $filters['nis'];
        }
        
        // Filter by tanggal
        if (!empty($filters['tanggal_mulai'])) {
            $sql .= " AND DATE(ia.tanggal_input) >= ?";
            $params[] = $filters['tanggal_mulai'];
        }
        
        if (!empty($filters['tanggal_akhir'])) {
            $sql .= " AND DATE(ia.tanggal_input) <= ?";
            $params[] = $filters['tanggal_akhir'];
        }
        
        // Filter by bulan
        if (!empty($filters['bulan'])) {
            $sql .= " AND MONTH(ia.tanggal_input) = ?";
            $params[] = $filters['bulan'];
        }
        
        // Filter by tahun
        if (!empty($filters['tahun'])) {
            $sql .= " AND YEAR(ia.tanggal_input) = ?";
            $params[] = $filters['tahun'];
        }
        
        $sql .= " ORDER BY ia.tanggal_input DESC";
        
        return $this->db->query($sql, $params)->fetchAll();
    }
    
    /**
     * Mendapatkan aspirasi milik siswa tertentu
     * @param int $nis
     * @return array
     */
    public function getByNis(int $nis): array {
        return $this->getAllWithDetail(['nis' => $nis]);
    }
    
    /**
     * Mendapatkan statistik aspirasi
     * @return array
     */
    public function getStatistics(): array {
        $sql = "SELECT 
                    COUNT(*) as total,
                    SUM(CASE WHEN a.status = 'Menunggu' THEN 1 ELSE 0 END) as menunggu,
                    SUM(CASE WHEN a.status = 'Proses' THEN 1 ELSE 0 END) as proses,
                    SUM(CASE WHEN a.status = 'Selesai' THEN 1 ELSE 0 END) as selesai
                FROM {$this->table} ia
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan";
        return $this->db->query($sql)->fetch();
    }
    
    /**
     * Mendapatkan statistik aspirasi per kategori
     * @return array
     */
    public function getStatisticsByKategori(): array {
        $sql = "SELECT k.ket_kategori, COUNT(ia.id_pelaporan) as jumlah
                FROM kategori k
                LEFT JOIN input_aspirasi ia ON k.id_kategori = ia.id_kategori
                GROUP BY k.id_kategori
                ORDER BY jumlah DESC";
        return $this->db->query($sql)->fetchAll();
    }
}
